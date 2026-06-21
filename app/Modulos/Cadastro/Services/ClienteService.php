<?php

namespace App\Modulos\Cadastro\Services;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\DTO\ClienteDTO;
use App\Modulos\Cadastro\Models\ClienteContatoModel;
use App\Modulos\Cadastro\Models\ClienteEnderecoModel;
use App\Modulos\Cadastro\Models\ClienteModel;
use App\Modulos\Cadastro\Models\ClienteUsuarioModel;

class ClienteService
{
    public function listar(int $empresaId, int $perPage = 20): array
    {
        $model = model(ClienteModel::class);

        $rows = $model->comEmpresa()
            ->comSituacao()
            ->comTipo()
            ->where('CLIENTES.EMPRESA_ID', $empresaId)
            ->orderBy('CLIENTES.NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn($row) => ClienteDTO::fromObject($row), $rows);

        return [
            'itens'    => $itens,
            'pager'    => $model->pager,
        ];
    }

    public function encontrar(int $id): ?ClienteDTO
    {
        $model = model(ClienteModel::class);

        $row = $model->comEmpresa()
            ->comSituacao()
            ->comTipo()
            ->find($id);

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

        return $model->where('CLIENTE_ID', $clienteId)
            ->orderBy('PRINCIPAL', 'DESC')
            ->findAll();
    }

    public function criarEndereco(array $data): ?int
    {
        $model = model(ClienteEnderecoModel::class);

        return $model->insert($data) ? (int) $model->getInsertID() : null;
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

        return $model->insert($data) ? (int) $model->getInsertID() : null;
    }

    public function listarUsuarios(int $clienteId): array
    {
        $model = model(ClienteUsuarioModel::class);

        return $model->where('CLIENTE_ID', $clienteId)
            ->findAll();
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
}
