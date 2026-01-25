<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'dashboard',
            'governanca_pastoral',
            'administracao_geral',
            'gestao_pessoas_lideranca',
            'gestao_membros_discipulado',
            'ministerios_atividades',
            'comunicacao_evangelismo',
            'gestao_financeira',
            'patrimonio_infraestrutura',
            'acao_social_diaconia',
            'tecnologia_informacao',
            'juridico_compliance',
            'eventos_programacao',
            'logs_erros',
            'qualidade_codigo',
            'inspetor_banco',
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'approve'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $module . '.' . $action]);
            }
        }
    }
}
