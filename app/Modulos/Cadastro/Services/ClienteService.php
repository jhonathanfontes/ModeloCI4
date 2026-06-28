<?php

namespace App\Modulos\Cadastro\Services;

use App\Dominios\SituacaoRegistro;
use App\Models\PessoaModel;
use App\Modulos\Cadastro\DTO\ClienteDTO;
use App\Modulos\Cadastro\Models\ClienteContatoModel;
use App\Modulos\Cadastro\Models\ClienteEnderecoModel;
use App\Modulos\Cadastro\Models\ClienteModel;
use App\Modulos\Cadastro\Models\ClienteUsuarioModel;

class ClienteService
{
    public function listar(int $empresaId, int $perPage = 20, ?string $busca = null): array
    {
        $model = model(ClienteModel::class);

        $query = $model->comEmpresa()
            ->comPessoa()
            ->comSituacao()
            ->comTipo()
            ->where('CLIENTES.EMPRESA_ID', $empresaId);

        if ($busca !== null && trim($busca) !== '') {
            $buscaClean = trim($busca);
            $query->groupStart()
                ->like('CLIENTES.NOME', $buscaClean)
                ->orLike('CLIENTES.NOME_FANTASIA', $buscaClean)
                ->orLike('PESSOAS.CPF_CNPJ', preg_replace('/\D/', '', $buscaClean))
                ->groupEnd();
        }

        $rows = $query->orderBy('CLIENTES.NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn ($row) => ClienteDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrar(int $id): ?ClienteDTO
    {
        $model = model(ClienteModel::class);

        $row = $model->comEmpresa()
            ->comPessoa()
            ->comSituacao()
            ->comTipo()
            ->find($id);

        return $row !== null ? ClienteDTO::fromObject($row) : null;
    }

    public function encontrarPorUuid(string $uuid): ?ClienteDTO
    {
        $model = model(ClienteModel::class);

        $row = $model->comEmpresa()
            ->comPessoa()
            ->comSituacao()
            ->comTipo()
            ->findByUuid($uuid);

        return $row !== null ? ClienteDTO::fromObject($row) : null;
    }

    public function criar(array $data): ?int
    {
        $model = model(ClienteModel::class);

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function atualizar(int $id, array $data): bool
    {
        $model = model(ClienteModel::class);

        unset($data['ID_CLIENTE'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        return $model->update($id, $data);
    }

    public function excluir(int $id): bool
    {
        $model = model(ClienteModel::class);

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        return $model->update($id, ['SITUACAO_ID' => $situacaoCancelado]);
    }

    public function deletarFisicamente(int $id): bool
    {
        $model = model(ClienteModel::class);

        return $model->delete($id);
    }

    public function listarEnderecos(int $clienteId): array
    {
        $model = model(ClienteEnderecoModel::class);

        return $model->select('CLIE_ENDERECOS.*, SIST_TIPOS.DESCRICAO as TIPO_DESCRICAO, SIST_TIPOS.CODIGO as TIPO_CODIGO')
            ->join('SIST_TIPOS', 'SIST_TIPOS.ID_TIPO = CLIE_ENDERECOS.TIPO_ID', 'left')
            ->where('CLIE_ENDERECOS.CLIENTE_ID', $clienteId)
            ->orderBy('CLIE_ENDERECOS.PRINCIPAL', 'DESC')
            ->findAll();
    }

    public function criarEndereco(array $data): ?int
    {
        $model = model(ClienteEnderecoModel::class);

        $insertId = $model->insert($data) ? (int) $model->getInsertID() : null;

        if ($insertId !== null && isset($data['PRINCIPAL']) && (int) $data['PRINCIPAL'] === 1) {
            $this->tratarEnderecoPrincipal((int) $data['CLIENTE_ID'], $insertId, 1);
        }

        return $insertId;
    }

    public function encontrarEndereco(int $id): ?object
    {
        return model(ClienteEnderecoModel::class)->find($id);
    }

    public function atualizarEndereco(int $id, array $data): bool
    {
        $model = model(ClienteEnderecoModel::class);
        unset($data['ID_ENDERECO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        $updated = $model->update($id, $data);

        if ($updated && isset($data['PRINCIPAL']) && (int) $data['PRINCIPAL'] === 1) {
            $endereco = $model->find($id);
            if (is_object($endereco)) {
                $this->tratarEnderecoPrincipal((int) $endereco->CLIENTE_ID, $id, 1);
            }
        }

        return $updated;
    }

    public function excluirEndereco(int $id): bool
    {
        return model(ClienteEnderecoModel::class)->delete($id);
    }

    public function encontrarEnderecoPrincipal(int $clienteId): ?object
    {
        return model(ClienteEnderecoModel::class)
            ->where('CLIENTE_ID', $clienteId)
            ->where('PRINCIPAL', 1)
            ->first();
    }

    public function listarContatos(int $clienteId): array
    {
        $model = model(ClienteContatoModel::class);

        return $model->where('CLIENTE_ID', $clienteId)
            ->orderBy('PRINCIPAL', 'DESC')
            ->findAll();
    }

    public function criarContato(array $data): ?int
    {
        $model = model(ClienteContatoModel::class);

        $insertId = $model->insert($data) ? (int) $model->getInsertID() : null;

        if ($insertId !== null && isset($data['PRINCIPAL']) && (int) $data['PRINCIPAL'] === 1) {
            $this->tratarContatoPrincipal((int) $data['CLIENTE_ID'], $insertId, 1);
        }

        return $insertId;
    }

    public function encontrarContato(int $id): ?object
    {
        return model(ClienteContatoModel::class)->find($id);
    }

    public function encontrarContatoPrincipal(int $clienteId): ?object
    {
        return model(ClienteContatoModel::class)
            ->where('CLIENTE_ID', $clienteId)
            ->where('PRINCIPAL', 1)
            ->first();
    }

    public function atualizarContato(int $id, array $data): bool
    {
        $model = model(ClienteContatoModel::class);
        unset($data['ID_CONTATO'], $data['UUID'], $data['CRIADO_EM'], $data['CRIADO_POR']);

        $updated = $model->update($id, $data);

        if ($updated && isset($data['PRINCIPAL']) && (int) $data['PRINCIPAL'] === 1) {
            $contato = $model->find($id);
            if (is_object($contato)) {
                $this->tratarContatoPrincipal((int) $contato->CLIENTE_ID, $id, 1);
            }
        }

        return $updated;
    }

    public function excluirContato(int $id): bool
    {
        return model(ClienteContatoModel::class)->delete($id);
    }

    public function listarUsuarios(int $clienteId): array
    {
        $model = model(ClienteUsuarioModel::class);

        return $model->where('CLIENTE_ID', $clienteId)
            ->findAll();
    }

    public function findOrCreatePessoa(?string $cpfCnpj, ?string $dataNascimento = null, ?int $criadoPor = null): ?int
    {
        $cpfCnpj = preg_replace('/\D/', '', $cpfCnpj ?? '');
        if (empty($cpfCnpj)) {
            return null;
        }

        $model = model(PessoaModel::class);

        $pessoa = $model->findByCpfCnpj($cpfCnpj);
        if ($pessoa !== null) {
            $dbDate = $pessoa->DATA_NASCIMENTO ? substr($pessoa->DATA_NASCIMENTO, 0, 10) : null;
            $newDate = $dataNascimento ? substr($dataNascimento, 0, 10) : null;
            if ($newDate !== $dbDate) {
                $model->update($pessoa->ID_PESSOA, [
                    'DATA_NASCIMENTO' => $newDate ?: null,
                    'ATUALIZADO_POR' => $criadoPor,
                ]);
            }

            return (int) $pessoa->ID_PESSOA;
        }

        $situacaoAtivo = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $insertId = $model->insert([
            'CPF_CNPJ' => $cpfCnpj,
            'DATA_NASCIMENTO' => $dataNascimento ?: null,
            'SITUACAO_ID' => $situacaoAtivo,
            'CRIADO_POR' => $criadoPor,
            'ATUALIZADO_POR' => $criadoPor,
        ]);

        return $insertId ? (int) $model->getInsertID() : null;
    }

    public function criarUsuario(array $data): ?int
    {
        $model = model(ClienteUsuarioModel::class);

        if (isset($data['SENHA'])) {
            $data['SENHA_HASH'] = password_hash($data['SENHA'], PASSWORD_BCRYPT);
            unset($data['SENHA']);
        }

        $data['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    private function tratarEnderecoPrincipal(int $clienteId, int $enderecoId, int $principal): void
    {
        if ($principal === 1) {
            model(ClienteEnderecoModel::class)
                ->builder()
                ->where('CLIENTE_ID', $clienteId)
                ->where('ID_ENDERECO !=', $enderecoId)
                ->update(['PRINCIPAL' => 0]);
        }
    }

    private function tratarContatoPrincipal(int $clienteId, int $contatoId, int $principal): void
    {
        if ($principal === 1) {
            model(ClienteContatoModel::class)
                ->builder()
                ->where('CLIENTE_ID', $clienteId)
                ->where('ID_CONTATO !=', $contatoId)
                ->update(['PRINCIPAL' => 0]);
        }
    }
}
