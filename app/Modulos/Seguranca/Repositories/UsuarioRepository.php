<?php

namespace App\Modulos\Seguranca\Repositories;

use App\Dominios\SituacaoRegistro;
use App\Modulos\Seguranca\DTO\UsuarioDTO;
use App\Modulos\Seguranca\Models\PerfilModel;
use App\Modulos\Seguranca\Models\UsuarioAccountModel;
use App\Modulos\Seguranca\Models\UsuarioEmpresaModel;
use App\Modulos\Seguranca\Models\UsuarioModel;

class UsuarioRepository
{
    public function listar(int $perPage = 20): array
    {
        $model = model(UsuarioModel::class);

        $rows = $model->comSituacao()
            ->orderBy('NOME', 'ASC')
            ->paginate($perPage);

        $itens = array_map(fn($row) => UsuarioDTO::fromObject($row), $rows);

        return [
            'itens' => $itens,
            'pager' => $model->pager,
        ];
    }

    public function encontrar(int $id): ?UsuarioDTO
    {
        $model = model(UsuarioModel::class);

        $row = $model->comSituacao()->find($id);
        if ($row === null) {
            return null;
        }

        $dto = UsuarioDTO::fromObject($row);

        return $dto;
    }

    public function encontrarComEmpresas(int $id): ?UsuarioDTO
    {
        $model = model(UsuarioModel::class);

        $row = $model->comSituacao()->find($id);
        if ($row === null) {
            return null;
        }

        $empresas = model(UsuarioEmpresaModel::class)
            ->select('USUA_USUARIO_EMPRESAS.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME, PERF_PERFIS.NOME AS PERFIL_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = USUA_USUARIO_EMPRESAS.EMPRESA_ID', 'left')
            ->join('PERF_PERFIS', 'PERF_PERFIS.ID_PERFIL = USUA_USUARIO_EMPRESAS.PERFIL_ID', 'left')
            ->where('USUA_USUARIO_EMPRESAS.USUARIO_ID', $id)
            ->findAll();

        $dto = UsuarioDTO::fromObject($row);

        return new UsuarioDTO(
            id: $dto->id,
            uuid: $dto->uuid,
            nome: $dto->nome,
            email: $dto->email,
            tipo: $dto->tipo,
            ultimoLogin: $dto->ultimoLogin,
            tentativasLogin: $dto->tentativasLogin,
            situacaoId: $dto->situacaoId,
            situacaoCodigo: $dto->situacaoCodigo,
            situacaoCor: $dto->situacaoCor,
            situacaoDescricao: $dto->situacaoDescricao,
            empresas: $empresas,
            criadoEm: $dto->criadoEm,
            atualizadoEm: $dto->atualizadoEm,
        );
    }

    public function salvar(array $dadosUsuario, ?array $dadosAccount = null): ?int
    {
        $model = model(UsuarioModel::class);
        $db = db_connect();

        $db->transStart();

        if (isset($dadosUsuario['SENHA'])) {
            $dadosUsuario['SENHA_HASH'] = password_hash($dadosUsuario['SENHA'], PASSWORD_BCRYPT);
            unset($dadosUsuario['SENHA']);
        }

        $dadosUsuario['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        $usuarioId = $model->insert($dadosUsuario);
        if ($usuarioId === false) {
            $db->transRollback();
            return null;
        }

        $usuarioId = (int) $model->getInsertID();

        if ($dadosAccount !== null) {
            $dadosAccount['USUARIO_ID'] = $usuarioId;

            if (isset($dadosAccount['SENHA'])) {
                $dadosAccount['SENHA_HASH'] = password_hash($dadosAccount['SENHA'], PASSWORD_BCRYPT);
                unset($dadosAccount['SENHA']);
            }

            $dadosAccount['SITUACAO_ID'] ??= service('situacao')->getId(
                SituacaoRegistro::MODULO,
                SituacaoRegistro::ATIVO
            );

            model(UsuarioAccountModel::class)->insert($dadosAccount);
        }

        $db->transComplete();

        return $db->transStatus() ? $usuarioId : null;
    }

    public function atualizar(int $id, array $dados): bool
    {
        $model = model(UsuarioModel::class);

        if (isset($dados['SENHA'])) {
            $dados['SENHA_HASH'] = password_hash($dados['SENHA'], PASSWORD_BCRYPT);
            unset($dados['SENHA']);
        }

        unset($dados['ID_USUARIO'], $dados['UUID'], $dados['CRIADO_EM'], $dados['CRIADO_POR']);

        return $model->update($id, $dados);
    }

    public function cancelar(int $id, ?int $usuarioId = null): bool
    {
        $model = model(UsuarioModel::class);
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

        model(UsuarioAccountModel::class)
            ->where('USUARIO_ID', $id)
            ->set($dados)
            ->update();

        model(UsuarioEmpresaModel::class)
            ->where('USUARIO_ID', $id)
            ->set($dados)
            ->update();

        $db->transComplete();

        return $db->transStatus();
    }

    public function excluirFisicamente(int $id): bool
    {
        $db = db_connect();
        $db->transStart();

        model(UsuarioAccountModel::class)->where('USUARIO_ID', $id)->delete();
        model(UsuarioEmpresaModel::class)->where('USUARIO_ID', $id)->delete();
        model(UsuarioModel::class)->delete($id);

        $db->transComplete();

        return $db->transStatus();
    }

    public function vincularEmpresa(array $dados): ?int
    {
        $model = model(UsuarioEmpresaModel::class);

        $dados['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($dados) ? (int) $model->getInsertID() : null;
    }

    public function desvincularEmpresa(int $id): bool
    {
        return model(UsuarioEmpresaModel::class)->delete($id);
    }

    public function empresasDoUsuario(int $usuarioId): array
    {
        return model(UsuarioEmpresaModel::class)
            ->select('USUA_USUARIO_EMPRESAS.*, EMPRESAS.NOME_FANTASIA AS EMPRESA_NOME, PERF_PERFIS.NOME AS PERFIL_NOME')
            ->join('EMPRESAS', 'EMPRESAS.ID_EMPRESA = USUA_USUARIO_EMPRESAS.EMPRESA_ID', 'left')
            ->join('PERF_PERFIS', 'PERF_PERFIS.ID_PERFIL = USUA_USUARIO_EMPRESAS.PERFIL_ID', 'left')
            ->where('USUA_USUARIO_EMPRESAS.USUARIO_ID', $usuarioId)
            ->findAll();
    }

    public function listarPerfis(): array
    {
        return model(PerfilModel::class)
            ->orderBy('NIVEL', 'DESC')
            ->findAll();
    }

    public function salvarPerfil(array $dados): ?int
    {
        $model = model(PerfilModel::class);

        $dados['SITUACAO_ID'] ??= service('situacao')->getId(
            SituacaoRegistro::MODULO,
            SituacaoRegistro::ATIVO
        );

        return $model->insert($dados) ? (int) $model->getInsertID() : null;
    }

    public function atualizarPerfil(int $id, array $dados): bool
    {
        unset($dados['ID_PERFIL'], $dados['UUID'], $dados['CRIADO_EM'], $dados['CRIADO_POR']);

        return model(PerfilModel::class)->update($id, $dados);
    }

    public function excluirPerfil(int $id): bool
    {
        return model(PerfilModel::class)->delete($id);
    }
}
