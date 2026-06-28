<?php

namespace App\Controllers\Admin;

use App\Modulos\Sistema\Rules\SituacaoRules;
use CodeIgniter\HTTP\ResponseInterface;

class Situacoes extends BaseController
{
    public function index(): string
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');
        $situacoes = $model->orderBy('MODULO', 'ASC')->orderBy('CODIGO', 'ASC')->findAll();

        return $this->render('Modulos/admin/situacoes/index', [
            'title' => 'Situações',
            'situacoes' => $situacoes,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/admin/situacoes/form', [
            'title' => 'Nova Situação',
            'situacao' => null,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');
        $situacao = $model->findByUuid($uuid);

        if ($situacao === null) {
            return redirect()->to(route_to('admin.situacoes'))
                ->with('error', 'Situação não encontrada.');
        }

        return $this->render('Modulos/admin/situacoes/form', [
            'title' => 'Editar Situação',
            'situacao' => $situacao,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_SITUACAO') ?: 0);
        $rules = $id > 0 ? SituacaoRules::atualizacao($id) : SituacaoRules::cadastro();

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'MODULO' => $this->request->getPost('MODULO'),
            'CODIGO' => $this->request->getPost('CODIGO'),
            'DESCRICAO' => $this->request->getPost('DESCRICAO'),
            'COR' => $this->request->getPost('COR') ?: null,
            'FINALIZADO' => (int) ($this->request->getPost('FINALIZADO') ?: 0),
            'CONCLUIDA' => (int) ($this->request->getPost('CONCLUIDA') ?: 0),
            'CANCELADA' => (int) ($this->request->getPost('CANCELADA') ?: 0),
            'PENDENTE' => (int) ($this->request->getPost('PENDENTE') ?: 0),
            'BLOQUEIA_EDICAO' => (int) ($this->request->getPost('BLOQUEIA_EDICAO') ?: 0),
            'GERA_HISTORICO' => (int) ($this->request->getPost('GERA_HISTORICO') ?: 0),
        ];

        $model = model('App\Modulos\Sistema\Models\SituacaoModel');

        if ($id > 0) {
            unset($data['CODIGO']);
            $model->update($id, $data);

            return redirect()->to(route_to('admin.situacoes'))
                ->with('success', 'Situação atualizada com sucesso.');
        }

        $model->insert($data);

        return redirect()->to(route_to('admin.situacoes'))
            ->with('success', 'Situação criada com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $model = model('App\Modulos\Sistema\Models\SituacaoModel');
        $situacao = $model->findByUuid($uuid);

        if ($situacao === null) {
            return redirect()->back()
                ->with('error', 'Situação não encontrada.');
        }

        $model->delete($situacao->ID_SITUACAO);

        return redirect()->to(route_to('admin.situacoes'))
            ->with('success', 'Situação excluída com sucesso.');
    }
}
