<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastor Geral tem todas as permissions
        $pastorGeral = Role::where('name', 'Pastor Geral')->first();
        $pastorGeral->givePermissionTo(Permission::all());

        // Diretor Administrativo
        $diretorAdmin = Role::where('name', 'Diretor Administrativo')->first();
        $diretorAdmin->givePermissionTo([
            'governanca_pastoral.view', 'governanca_pastoral.create', 'governanca_pastoral.edit', 'governanca_pastoral.approve',
            'administracao_geral.view', 'administracao_geral.create', 'administracao_geral.edit',
            'gestao_financeira.view', 'gestao_financeira.create', 'gestao_financeira.edit', 'gestao_financeira.approve',
            'juridico_compliance.view', 'juridico_compliance.create',
        ]);

        // Financeiro
        $financeiro = Role::where('name', 'Financeiro')->first();
        $financeiro->givePermissionTo([
            'gestao_financeira.view', 'gestao_financeira.create', 'gestao_financeira.edit',
        ]);

        // Secretária
        $secretaria = Role::where('name', 'Secretária')->first();
        $secretaria->givePermissionTo([
            'administracao_geral.view', 'administracao_geral.create', 'administracao_geral.edit',
        ]);

        // Coordenador de Ministério
        $coordenadorMinisterio = Role::where('name', 'Coordenador de Ministério')->first();
        $coordenadorMinisterio->givePermissionTo([
            'ministerios_atividades.view', 'ministerios_atividades.create', 'ministerios_atividades.edit',
            'gestao_pessoas_lideranca.view', 'gestao_pessoas_lideranca.create',
        ]);

        // Voluntário
        $voluntario = Role::where('name', 'Voluntário')->first();
        $voluntario->givePermissionTo([
            'ministerios_atividades.view',
        ]);

        // Usuário Comum
        $usuarioComum = Role::where('name', 'Usuário Comum')->first();
        $usuarioComum->givePermissionTo([
            'comunicacao_evangelismo.view',
        ]);

        // Administrador de TI
        $adminTI = Role::where('name', 'Administrador de TI')->first();
        $adminTI->givePermissionTo([
            'logs_erros.view', 'logs_erros.create', 'logs_erros.edit', 'logs_erros.delete', 'logs_erros.approve',
        ]);

        // Analista de Logs
        $analistaLogs = Role::where('name', 'Analista de Logs')->first();
        $analistaLogs->givePermissionTo([
            'logs_erros.view', 'logs_erros.edit',
        ]);

        // Auditor Jurídico
        $auditorJuridico = Role::where('name', 'Auditor Jurídico')->first();
        $auditorJuridico->givePermissionTo([
            'logs_erros.view', // only audit trail
        ]);
    }
}
