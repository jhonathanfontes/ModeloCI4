<?php

namespace App\Controllers\Painel;

use App\Modulos\Cadastro\Services\ClienteService;
use CodeIgniter\HTTP\ResponseInterface;

class Clientes extends BaseController
{
    private ClienteService $clienteService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->clienteService = service('cliente');
    }

    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/clientes/index', [
                'title' => 'Clientes',
                'clientes' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $perPage = (int) ($this->request->getGet('per_page') ?: 20);
        $busca = $this->request->getGet('busca');
        $result = $this->clienteService->listar((int) $empresaAtiva['id'], $perPage, $busca);

        return $this->render('Modulos/painel/clientes/index', [
            'title' => 'Clientes',
            'clientes' => $result['itens'],
            'pager' => $result['pager'],
            'busca' => $busca,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/clientes/form', [
            'title' => 'Novo Cliente',
            'cliente' => null,
            'enderecos' => [],
            'contatos' => [],
            'contatoPrincipal' => null,
            'enderecoPrincipal' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function visualizar(string $uuid): ResponseInterface|string
    {
        $cliente = $this->clienteService->encontrarPorUuid($uuid);

        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))
                ->with('error', 'Cliente não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/visualizar', [
            'title' => 'Visualizar Cliente',
            'cliente' => $cliente,
            'enderecos' => $this->clienteService->listarEnderecos($cliente->id),
            'contatos' => $this->clienteService->listarContatos($cliente->id),
            'contatoPrincipal' => $this->clienteService->encontrarContatoPrincipal($cliente->id),
            'enderecoPrincipal' => $this->clienteService->encontrarEnderecoPrincipal($cliente->id),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $cliente = $this->clienteService->encontrarPorUuid($uuid);

        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))
                ->with('error', 'Cliente não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/form', [
            'title' => 'Editar Cliente',
            'cliente' => $cliente,
            'enderecos' => $this->clienteService->listarEnderecos($cliente->id),
            'contatos' => $this->clienteService->listarContatos($cliente->id),
            'contatoPrincipal' => $this->clienteService->encontrarContatoPrincipal($cliente->id),
            'enderecoPrincipal' => $this->clienteService->encontrarEnderecoPrincipal($cliente->id),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return redirect()->back()->with('error', 'Selecione uma empresa primeiro.');
        }

        $rules = \App\Modulos\Cadastro\Rules\ClienteRules::cadastro();
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (int) ($this->request->getPost('ID_CLIENTE') ?: 0);
        $cpfCnpj = preg_replace('/\D/', '', $this->request->getPost('CPF_CNPJ') ?? '');
        $usuarioId = session('usuario')['id'] ?? 1;

        $pessoaId = $this->clienteService->findOrCreatePessoa(
            $cpfCnpj,
            $this->request->getPost('DATA_NASCIMENTO') ?: null,
            $usuarioId
        );

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'PESSOA_ID' => $pessoaId,
            'NOME' => $this->request->getPost('NOME'),
            'NOME_FANTASIA' => $this->request->getPost('NOME_FANTASIA') ?: null,
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $data['ATUALIZADO_POR'] = $usuarioId;

        if ($id > 0) {
            if (! $this->clienteService->atualizar($id, $data)) {
                $errors = model(\App\Modulos\Cadastro\Models\ClienteModel::class)->errors();
                $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao atualizar cliente.';

                return redirect()->back()->withInput()
                    ->with('errors', $errors)
                    ->with('error', $errorMessage);
            }

            $this->salvarContatoPrincipal($id, $usuarioId);
            $this->salvarEnderecoPrincipal($id, $usuarioId);

            return redirect()->to(route_to('painel.clientes'))
                ->with('success', 'Cliente atualizado com sucesso.');
        }

        $data['CRIADO_POR'] = $usuarioId;
        $insertId = $this->clienteService->criar($data);

        if ($insertId === null) {
            $errors = model(\App\Modulos\Cadastro\Models\ClienteModel::class)->errors();
            $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao criar cliente.';

            return redirect()->back()->withInput()
                ->with('errors', $errors)
                ->with('error', $errorMessage);
        }

        $this->salvarContatoPrincipal($insertId, $usuarioId);
        $this->salvarEnderecoPrincipal($insertId, $usuarioId);

        $clienteCriado = $this->clienteService->encontrar($insertId);

        return redirect()->to(route_to('painel.clientes.editar', $clienteCriado->uuid))
            ->with('success', 'Cliente criado com sucesso.');
    }

    private function salvarContatoPrincipal(int $clienteId, int $usuarioId): void
    {
        $telefone = preg_replace('/\D/', '', $this->request->getPost('CONTATO_TELEFONE') ?? '');
        $whatsapp = preg_replace('/\D/', '', $this->request->getPost('CONTATO_WHATSAPP') ?? '');
        $email = $this->request->getPost('CONTATO_EMAIL') ?: null;

        if (empty($telefone) && empty($whatsapp) && empty($email)) {
            return;
        }

        $contatoAtual = $this->clienteService->encontrarContatoPrincipal($clienteId);
        $nomeCliente = $this->request->getPost('NOME');

        $data = [
            'CLIENTE_ID' => $clienteId,
            'NOME' => $nomeCliente,
            'CARGO' => 'Principal',
            'TELEFONE' => $telefone ?: null,
            'EMAIL' => $email,
            'WHATSAPP' => $whatsapp ?: null,
            'PRINCIPAL' => 1,
            'ATUALIZADO_POR' => $usuarioId,
        ];

        if ($contatoAtual !== null) {
            $this->clienteService->atualizarContato((int) $contatoAtual->ID_CONTATO, $data);
        } else {
            $data['CRIADO_POR'] = $usuarioId;
            $this->clienteService->criarContato($data);
        }
    }

    private function salvarEnderecoPrincipal(int $clienteId, int $usuarioId): void
    {
        $cep = preg_replace('/\D/', '', $this->request->getPost('ENDERECO_CEP') ?? '');
        if (empty($cep)) {
            return;
        }

        $enderecoAtual = $this->clienteService->encontrarEnderecoPrincipal($clienteId);

        $data = [
            'CLIENTE_ID' => $clienteId,
            'TIPO_ID' => 1,
            'CEP' => $cep,
            'LOGRADOURO' => $this->request->getPost('ENDERECO_LOGRADOURO') ?: null,
            'NUMERO' => $this->request->getPost('ENDERECO_NUMERO') ?: null,
            'COMPLEMENTO' => $this->request->getPost('ENDERECO_COMPLEMENTO') ?: null,
            'BAIRRO' => $this->request->getPost('ENDERECO_BAIRRO') ?: null,
            'CIDADE' => $this->request->getPost('ENDERECO_CIDADE') ?: null,
            'UF' => strtoupper($this->request->getPost('ENDERECO_UF') ?? ''),
            'PRINCIPAL' => 1,
            'ATUALIZADO_POR' => $usuarioId,
        ];

        if ($enderecoAtual !== null) {
            $this->clienteService->atualizarEndereco((int) $enderecoAtual->ID_ENDERECO, $data);
        } else {
            $data['CRIADO_POR'] = $usuarioId;
            $this->clienteService->criarEndereco($data);
        }
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($uuid);

        if ($cliente === null) {
            return redirect()->back()
                ->with('error', 'Cliente não encontrado.');
        }

        $this->clienteService->excluir($cliente->id);

        return redirect()->to(route_to('painel.clientes'))
            ->with('success', 'Cliente cancelado com sucesso.');
    }

    public function enderecoNovo(string $clienteUuid): string|ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/endereco_form', [
            'title' => 'Novo Endereço',
            'cliente' => $cliente,
            'endereco' => null,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function enderecoEditar(string $clienteUuid, int $enderecoId): string|ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        $endereco = $this->clienteService->encontrarEndereco($enderecoId);
        if ($endereco === null || (int) $endereco->CLIENTE_ID !== $cliente->id) {
            return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('error', 'Endereço não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/endereco_form', [
            'title' => 'Editar Endereço',
            'cliente' => $cliente,
            'endereco' => $endereco,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function enderecoSalvar(string $clienteUuid): ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        $id = (int) ($this->request->getPost('ID_ENDERECO') ?: 0);

        $rules = \App\Modulos\Cadastro\Rules\ClienteRules::endereco();
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'CLIENTE_ID' => $cliente->id,
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'CEP' => preg_replace('/\D/', '', $this->request->getPost('CEP') ?? ''),
            'LOGRADOURO' => $this->request->getPost('LOGRADOURO'),
            'NUMERO' => $this->request->getPost('NUMERO'),
            'COMPLEMENTO' => $this->request->getPost('COMPLEMENTO') ?: null,
            'BAIRRO' => $this->request->getPost('BAIRRO'),
            'CIDADE' => $this->request->getPost('CIDADE'),
            'UF' => strtoupper($this->request->getPost('UF') ?? ''),
            'PRINCIPAL' => (int) ($this->request->getPost('PRINCIPAL') ?: 0),
        ];

        if ($id > 0) {
            unset($data['PRINCIPAL']);
            $data['ATUALIZADO_POR'] = session('usuario')['id'] ?? 1;
            if (! $this->clienteService->atualizarEndereco($id, $data)) {
                $errors = model(\App\Modulos\Cadastro\Models\ClienteEnderecoModel::class)->errors();
                $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao atualizar endereço.';

                return redirect()->back()->withInput()
                    ->with('errors', $errors)
                    ->with('error', $errorMessage);
            }

            return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Endereço atualizado com sucesso.');
        }

        $data['CRIADO_POR'] = session('usuario')['id'] ?? 1;
        $data['ATUALIZADO_POR'] = session('usuario')['id'] ?? 1;
        if ($this->clienteService->criarEndereco($data) === null) {
            $errors = model(\App\Modulos\Cadastro\Models\ClienteEnderecoModel::class)->errors();
            $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao criar endereço.';

            return redirect()->back()->withInput()
                ->with('errors', $errors)
                ->with('error', $errorMessage);
        }

        return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Endereço cadastrado com sucesso.');
    }

    public function enderecoExcluir(string $clienteUuid, int $enderecoId): ResponseInterface
    {
        $this->clienteService->excluirEndereco($enderecoId);

        return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Endereço excluído com sucesso.');
    }

    public function contatoNovo(string $clienteUuid): string|ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/contato_form', [
            'title' => 'Novo Contato',
            'cliente' => $cliente,
            'contato' => null,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function contatoEditar(string $clienteUuid, int $contatoId): string|ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        $contato = $this->clienteService->encontrarContato($contatoId);
        if ($contato === null || (int) $contato->CLIENTE_ID !== $cliente->id) {
            return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('error', 'Contato não encontrado.');
        }

        return $this->render('Modulos/painel/clientes/contato_form', [
            'title' => 'Editar Contato',
            'cliente' => $cliente,
            'contato' => $contato,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function contatoSalvar(string $clienteUuid): ResponseInterface
    {
        $cliente = $this->clienteService->encontrarPorUuid($clienteUuid);
        if ($cliente === null) {
            return redirect()->to(route_to('painel.clientes'))->with('error', 'Cliente não encontrado.');
        }

        $id = (int) ($this->request->getPost('ID_CONTATO') ?: 0);

        $rules = \App\Modulos\Cadastro\Rules\ClienteRules::contato();
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $telefone = preg_replace('/\D/', '', $this->request->getPost('TELEFONE') ?? '');
        $whatsapp = preg_replace('/\D/', '', $this->request->getPost('WHATSAPP') ?? '');
        $email = $this->request->getPost('EMAIL');

        if (empty($telefone) && empty($whatsapp) && empty($email)) {
            return redirect()->back()->withInput()->with('error', 'Pelo menos um dos campos de contato (Telefone, E-mail ou WhatsApp) deve ser preenchido.');
        }

        $data = [
            'CLIENTE_ID' => $cliente->id,
            'NOME' => $this->request->getPost('NOME'),
            'CARGO' => $this->request->getPost('CARGO') ?: null,
            'TELEFONE' => $telefone ?: null,
            'EMAIL' => $email ?: null,
            'WHATSAPP' => $whatsapp ?: null,
            'PRINCIPAL' => (int) ($this->request->getPost('PRINCIPAL') ?: 0),
        ];

        if ($id > 0) {
            unset($data['PRINCIPAL']);
            $data['ATUALIZADO_POR'] = session('usuario')['id'] ?? 1;
            if (! $this->clienteService->atualizarContato($id, $data)) {
                $errors = model(\App\Modulos\Cadastro\Models\ClienteContatoModel::class)->errors();
                $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao atualizar contato.';

                return redirect()->back()->withInput()
                    ->with('errors', $errors)
                    ->with('error', $errorMessage);
            }

            return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Contato atualizado com sucesso.');
        }

        $data['CRIADO_POR'] = session('usuario')['id'] ?? 1;
        $data['ATUALIZADO_POR'] = session('usuario')['id'] ?? 1;
        if ($this->clienteService->criarContato($data) === null) {
            $errors = model(\App\Modulos\Cadastro\Models\ClienteContatoModel::class)->errors();
            $errorMessage = ! empty($errors) ? implode(', ', $errors) : 'Erro ao criar contato.';

            return redirect()->back()->withInput()
                ->with('errors', $errors)
                ->with('error', $errorMessage);
        }

        return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Contato cadastrado com sucesso.');
    }

    public function contatoExcluir(string $clienteUuid, int $contatoId): ResponseInterface
    {
        $this->clienteService->excluirContato($contatoId);

        return redirect()->to(route_to('painel.clientes.editar', $clienteUuid))->with('success', 'Contato excluído com sucesso.');
    }

}
