<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Pastor Geral',
            'Coordenador de Ministério',
            'Diretor Administrativo',
            'Financeiro',
            'Secretária',
            'Voluntário',
            'Usuário Comum',
            'Administrador de TI',
            'Analista de Logs',
            'Auditor Jurídico',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
