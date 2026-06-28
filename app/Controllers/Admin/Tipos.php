<?php

namespace App\Controllers\Admin;

use App\Dominios\TipoRegistro;
use App\Modulos\Sistema\Rules\TipoRules;
use CodeIgniter\HTTP\ResponseInterface;

class Tipos extends BaseController
{
    public function index(): string
    {
        $model = model('App\Modulos\Sistema\Models\TipoModel');
        $tipos = $model
            ->orderBy('MODULO', 'ASC')
            ->orderBy('ORDEM', 'ASC')
            ->orderBy('DESCRICAO', 'ASC')
            ->findAll();

        return $this->render('Modulos/admin/tipos/index', [
            'title' => 'Tipos',
            'tipos' => $tipos,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function novo(): string
    {
        return $this->render('Modulos/admin/tipos/form', [
            'title' => 'Novo Tipo',
            'tipo' => null,
            'modulosTipos' => $this->listarModulosTipos(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function editar(string $uuid): ResponseInterface|string
    {
        $model = model('App\Modulos\Sistema\Models\TipoModel');
        $tipo = $model->findByUuid($uuid);

        if ($tipo === null) {
            return redirect()->to(route_to('admin.tipos'))
                ->with('error', 'Tipo não encontrado.');
        }

        return $this->render('Modulos/admin/tipos/form', [
            'title' => 'Editar Tipo',
            'tipo' => $tipo,
            'modulosTipos' => $this->listarModulosTipos(),
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function salvar(): ResponseInterface
    {
        $id = (int) ($this->request->getPost('ID_TIPO') ?: 0);
        $rules = $id > 0 ? TipoRules::atualizacao($id) : TipoRules::cadastro();

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'MODULO' => $this->request->getPost('MODULO'),
            'CODIGO' => $this->request->getPost('CODIGO'),
            'DESCRICAO' => $this->request->getPost('DESCRICAO'),
            'ORDEM' => (int) ($this->request->getPost('ORDEM') ?: 0),
            'SITUACAO_ID' => (int) $this->request->getPost('SITUACAO_ID'),
        ];

        $model = model('App\Modulos\Sistema\Models\TipoModel');

        if ($id > 0) {
            unset($data['CODIGO']);
            $model->update($id, $data);

            return redirect()->to(route_to('admin.tipos'))
                ->with('success', 'Tipo atualizado com sucesso.');
        }

        $model->insert($data);

        return redirect()->to(route_to('admin.tipos'))
            ->with('success', 'Tipo criado com sucesso.');
    }

    public function excluir(string $uuid): ResponseInterface
    {
        $model = model('App\Modulos\Sistema\Models\TipoModel');
        $tipo = $model->findByUuid($uuid);

        if ($tipo === null) {
            return redirect()->back()
                ->with('error', 'Tipo não encontrado.');
        }

        $model->delete($tipo->ID_TIPO);

        return redirect()->to(route_to('admin.tipos'))
            ->with('success', 'Tipo excluído com sucesso.');
    }

    private function listarModulosTipos(): array
    {
        $ref = new \ReflectionClass(TipoRegistro::class);
        $constantes = [];
        foreach ($ref->getConstants() as $nome => $valor) {
            if (str_starts_with($nome, 'MODULO_')) {
                $constantes[] = $valor;
            }
        }
        return $constantes;
    }

}
