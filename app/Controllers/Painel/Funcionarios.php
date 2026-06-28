<?php

namespace App\Controllers\Painel;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\Models\FuncionarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Funcionarios extends BaseController
{
    public function index(): string
    {
        $empresaAtiva = session('empresaAtiva');

        if ($empresaAtiva === null) {
            return $this->render('Modulos/painel/funcionarios/index', [
                'title' => 'Funcionários',
                'itens' => [],
                'pager' => null,
                'error' => 'Selecione uma empresa primeiro.',
            ]);
        }

        $model = model(FuncionarioModel::class);
        $perPage = (int) ($this->request->getGet('per_page') ?: 20);

        $rows = $model->comSituacao()
            ->where('FUNCIONARIOS.EMPRESA_ID', (int) $empresaAtiva['id'])
            ->orderBy('FUNCIONARIOS.NOME', 'ASC')
            ->paginate($perPage);

        return $this->render('Modulos/painel/funcionarios/index', [
            'title' => 'Funcionários',
            'itens' => $rows,
            'pager' => $model->pager,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/painel/funcionarios/form', [
            'title' => 'Novo Funcionário',
            'item' => null,
            'departamentos' => $this->listarDepartamentos(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $model = model(FuncionarioModel::class);
        $item = $model->comSituacao()->findByUuid($uuid);

        if ($item === null) {
            return redirect()->to(route_to('painel.funcionarios'))
                ->with('error', 'Funcionário não encontrado.');
        }

        return $this->render('Modulos/painel/funcionarios/form', [
            'title' => 'Editar Funcionário',
            'item' => $item,
            'departamentos' => $this->listarDepartamentos(),
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

        if (! $this->validate(\App\Modulos\Cadastro\Rules\FuncionarioRules::cadastro())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (int) ($this->request->getPost('ID_FUNCIONARIO') ?: 0);
        $model = model(FuncionarioModel::class);

        $data = [
            'EMPRESA_ID' => (int) $empresaAtiva['id'],
            'NOME' => $this->request->getPost('NOME'),
            'EMAIL' => $this->request->getPost('EMAIL'),
            'CARGO' => $this->request->getPost('CARGO'),
            'TIPO_ID' => (int) $this->request->getPost('TIPO_ID'),
            'DEPARTAMENTO_ID' => $this->request->getPost('DEPARTAMENTO_ID') ? (int) $this->request->getPost('DEPARTAMENTO_ID') : null,
            'TELEFONE' => preg_replace('/\D/', '', $this->request->getPost('TELEFONE') ?? ''),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        if ($id > 0) {
            unset($data['EMPRESA_ID']);

            if (! $model->update($id, $data)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Erro ao atualizar funcionário.');
            }

            return redirect()->to(route_to('painel.funcionarios'))
                ->with('success', 'Funcionário atualizado com sucesso.');
        }

        $insertId = $model->insert($data);

        if (! $insertId) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao criar funcionário.');
        }

        return redirect()->to(route_to('painel.funcionarios'))
            ->with('success', 'Funcionário criado com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $model = model(FuncionarioModel::class);
        $item = $model->findByUuid($uuid);

        if ($item === null) {
            return redirect()->back()
                ->with('error', 'Funcionário não encontrado.');
        }

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        $model->update($item->ID_FUNCIONARIO, ['SITUACAO_ID' => $situacaoCancelado]);

        return redirect()->to(route_to('painel.funcionarios'))
            ->with('success', 'Funcionário cancelado com sucesso.');
    }

    private function listarDepartamentos(): array
    {
        return db_connect()->table('ORGA_DEPARTAMENTOS')
            ->orderBy('NOME', 'ASC')
            ->get()
            ->getResult();
    }

}
