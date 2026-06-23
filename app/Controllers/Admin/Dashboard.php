<?php

namespace App\Controllers\Admin;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return $this->render('Modulos/admin/dashboard', [
            'title' => 'Dashboard',
            'stats' => $this->getStats(),
            'activities' => $this->getRecentActivities(),
        ]);
    }

    private function getStats(): array
    {
        return [
            ['label' => 'Empresas',   'value' => '—', 'color' => '#4f46e5', 'icon' => 'building'],
            ['label' => 'Clientes',   'value' => '—', 'color' => '#0891b2', 'icon' => 'users'],
            ['label' => 'Usuários',   'value' => '—', 'color' => '#059669', 'icon' => 'user-check'],
            ['label' => 'Ativos',     'value' => '—', 'color' => '#d97706', 'icon' => 'activity'],
        ];
    }

    private function getRecentActivities(): array
    {
        return [];
    }
}
