<?php

namespace App\Modulos\Cadastro\Repositories;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Cadastro\DTO\ClienteDTO;
use App\Modulos\Cadastro\Models\ClienteContatoModel;
use App\Modulos\Cadastro\Models\ClienteEnderecoModel;
use App\Modulos\Cadastro\Models\ClienteModel;
use App\Modulos\Cadastro\Models\ClienteUsuarioModel;

class ClienteRepository
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
            'itens' => $itens,
            'pager' => $model->pager,
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

    public function salvar(array $dadosCliente, array $enderecos = [], array $contatos = []): ?int
    {
        $model = model(ClienteModel::class);
        $db = db_connect();

        $db->transStart();

        $dadosCliente['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $clienteId = $model->insert($dadosCliente);

        if ($clienteId === false) {
            $db->transRollback();
            return null;
        }

        $clienteId = (int) $model->getInsertID();

        foreach ($enderecos as $endereco) {
            $endereco['CLIENTE_ID'] = $clienteId;
            model(ClienteEnderecoModel::class)->insert($endereco);
        }

        foreach ($contatos as $contato) {
            $contato['CLIENTE_ID'] = $clienteId;
            model(ClienteContatoModel::class)->insert($contato);
        }

        $db->transComplete();

        return $db->transStatus() ? $clienteId : null;
    }

    public function atualizar(int $id, array $dados): bool
    {
        $model = model(ClienteModel::class);

        unset($dados['ID_CLIENTE'], $dados['UUID'], $dados['CRIADO_EM'], $dados['CRIADO_POR']);

        return $model->update($id, $dados);
    }

    public function cancelar(int $id, ?int $usuarioId = null): bool
    {
        $model = model(ClienteModel::class);
        $db = db_connect();

        $db->transStart();

        $situacaoCancelado = service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::CANCELADO
        );

        $dados = ['SITUACAO_ID' => $situacaoCancelado];
        if ($usuarioId !== null) {
            $dados['ATUALIZADO_POR'] = $usuarioId;
        }

        $model->update($id, $dados);
        model(ClienteUsuarioModel::class)
            ->where('CLIENTE_ID', $id)
            ->set($dados)
            ->update();

        $db->transComplete();

        return $db->transStatus();
    }

    public function excluirFisicamente(int $id): bool
    {
        $model = model(ClienteModel::class);
        $db = db_connect();

        $db->transStart();

        model(ClienteEnderecoModel::class)->where('CLIENTE_ID', $id)->delete();
        model(ClienteContatoModel::class)->where('CLIENTE_ID', $id)->delete();
        model(ClienteUsuarioModel::class)->where('CLIENTE_ID', $id)->delete();
        $model->delete($id);

        $db->transComplete();

        return $db->transStatus();
    }

    public function enderecos(int $clienteId): array
    {
        return model(ClienteEnderecoModel::class)
            ->where('CLIENTE_ID', $clienteId)
            ->orderBy('PRINCIPAL', 'DESC')
            ->findAll();
    }

    public function salvarEndereco(array $dados): ?int
    {
        $model = model(ClienteEnderecoModel::class);
        return $model->insert($dados) ? (int) $model->getInsertID() : null;
    }

    public function atualizarEndereco(int $id, array $dados): bool
    {
        return model(ClienteEnderecoModel::class)->update($id, $dados);
    }

    public function excluirEndereco(int $id): bool
    {
        return model(ClienteEnderecoModel::class)->delete($id);
    }

    public function contatos(int $clienteId): array
    {
        return model(ClienteContatoModel::class)
            ->where('CLIENTE_ID', $clienteId)
            ->orderBy('PRINCIPAL', 'DESC')
            ->findAll();
    }

    public function salvarContato(array $dados): ?int
    {
        $model = model(ClienteContatoModel::class);
        return $model->insert($dados) ? (int) $model->getInsertID() : null;
    }

    public function atualizarContato(int $id, array $dados): bool
    {
        return model(ClienteContatoModel::class)->update($id, $dados);
    }

    public function excluirContato(int $id): bool
    {
        return model(ClienteContatoModel::class)->delete($id);
    }

    public function usuarios(int $clienteId): array
    {
        return model(ClienteUsuarioModel::class)
            ->where('CLIENTE_ID', $clienteId)
            ->findAll();
    }

    public function salvarUsuario(array $dados): ?int
    {
        $model = model(ClienteUsuarioModel::class);

        if (isset($dados['SENHA'])) {
            $dados['SENHA_HASH'] = password_hash($dados['SENHA'], PASSWORD_BCRYPT);
            unset($dados['SENHA']);
        }

        $dados['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($dados) ? (int) $model->getInsertID() : null;
    }

    public function atualizarUsuario(int $id, array $dados): bool
    {
        if (isset($dados['SENHA'])) {
            $dados['SENHA_HASH'] = password_hash($dados['SENHA'], PASSWORD_BCRYPT);
            unset($dados['SENHA']);
        }

        return model(ClienteUsuarioModel::class)->update($id, $dados);
    }

    public function excluirUsuario(int $id): bool
    {
        return model(ClienteUsuarioModel::class)->delete($id);
    }
}
