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
        $pastorGeral?->givePermissionTo(Permission::all());

        // Diretor Administrativo - Acesso amplo administrativo
        $diretorAdmin = Role::where('name', 'Diretor Administrativo')->first();
        $diretorAdmin?->givePermissionTo([
            // Dashboard
            'dashboard.view',
            // Governança
            'governanca_pastoral.view', 'governanca_pastoral.create', 'governanca_pastoral.edit', 'governanca_pastoral.approve',
            'doctrines.view', 'doctrines.create', 'doctrines.edit',
            'pastoral_councils.view', 'pastoral_councils.create', 'pastoral_councils.edit',
            'pastoral_notes.view', 'pastoral_notes.create', 'pastoral_notes.edit',
            // Administração
            'administracao_geral.view', 'administracao_geral.create', 'administracao_geral.edit', 'administracao_geral.approve',
            'departments.view', 'departments.create', 'departments.edit',
            'announcements.view', 'announcements.create', 'announcements.edit',
            'documents.view', 'documents.create', 'documents.edit',
            'meeting_minutes.view', 'meeting_minutes.create', 'meeting_minutes.edit',
            // Membros
            'members.view', 'members.create', 'members.edit',
            'users.view', 'users.create', 'users.edit',
            // Financeiro
            'gestao_financeira.view', 'gestao_financeira.create', 'gestao_financeira.edit', 'gestao_financeira.approve',
            'financial_accounts.view', 'financial_accounts.create', 'financial_accounts.edit',
            'financial_transactions.view', 'financial_transactions.create', 'financial_transactions.edit',
            'budgets.view', 'budgets.create', 'budgets.edit',
            'financial_reports.view', 'financial_reports.create',
            'financial_audits.view',
            'fiscal_council_meetings.view', 'fiscal_council_meetings.create',
            'donations.view', 'donations.create', 'donations.edit',
            // Jurídico
            'juridico_compliance.view', 'juridico_compliance.create', 'juridico_compliance.edit',
            'legal_documents.view', 'legal_documents.create', 'legal_documents.edit',
            'lgpd_consents.view', 'lgpd_consents.create',
            'compliance_obligations.view', 'compliance_obligations.create', 'compliance_obligations.edit',
            // Eventos
            'eventos_programacao.view', 'eventos_programacao.create', 'eventos_programacao.edit',
            'events.view', 'events.create', 'events.edit',
            'event_venues.view', 'event_venues.create', 'event_venues.edit',
            'event_registrations.view', 'event_registrations.create', 'event_registrations.edit',
            // Patrimônio
            'patrimonio_infraestrutura.view', 'patrimonio_infraestrutura.create', 'patrimonio_infraestrutura.edit',
            'assets.view', 'assets.create', 'assets.edit',
            'space_bookings.view', 'space_bookings.create', 'space_bookings.edit',
            // Comunicação
            'comunicacao_evangelismo.view', 'comunicacao_evangelismo.create', 'comunicacao_evangelismo.edit',
            'social_posts.view', 'social_posts.create', 'social_posts.edit',
            'media.view', 'media.create', 'media.edit',
            'livestreams.view', 'livestreams.create', 'livestreams.edit',
        ]);

        // Financeiro
        $financeiro = Role::where('name', 'Financeiro')->first();
        $financeiro?->givePermissionTo([
            'dashboard.view',
            'gestao_financeira.view', 'gestao_financeira.create', 'gestao_financeira.edit',
            'financial_accounts.view', 'financial_accounts.create', 'financial_accounts.edit',
            'financial_transactions.view', 'financial_transactions.create', 'financial_transactions.edit',
            'transaction_categories.view', 'transaction_categories.create', 'transaction_categories.edit',
            'budgets.view', 'budgets.create', 'budgets.edit',
            'financial_reports.view', 'financial_reports.create',
            'donations.view', 'donations.create', 'donations.edit',
            'financial_audits.view',
            'fiscal_council_meetings.view', 'fiscal_council_meetings.create',
        ]);

        // Secretária
        $secretaria = Role::where('name', 'Secretária')->first();
        $secretaria?->givePermissionTo([
            'dashboard.view',
            'administracao_geral.view', 'administracao_geral.create', 'administracao_geral.edit',
            'departments.view', 'departments.create', 'departments.edit',
            'announcements.view', 'announcements.create', 'announcements.edit',
            'documents.view', 'documents.create', 'documents.edit',
            'meeting_minutes.view', 'meeting_minutes.create', 'meeting_minutes.edit',
            'members.view', 'members.create', 'members.edit',
            'event_registrations.view', 'event_registrations.create', 'event_registrations.edit',
            'space_bookings.view', 'space_bookings.create',
        ]);

        // Coordenador de Ministério
        $coordenadorMinisterio = Role::where('name', 'Coordenador de Ministério')->first();
        $coordenadorMinisterio?->givePermissionTo([
            'dashboard.view',
            'ministerios_atividades.view', 'ministerios_atividades.create', 'ministerios_atividades.edit',
            'worship_songs.view', 'worship_songs.create', 'worship_songs.edit',
            'worship_setlists.view', 'worship_setlists.create', 'worship_setlists.edit',
            'worship_teams.view', 'worship_teams.create', 'worship_teams.edit',
            'worship_rehearsals.view', 'worship_rehearsals.create', 'worship_rehearsals.edit',
            'gestao_pessoas_lideranca.view', 'gestao_pessoas_lideranca.create',
            'volunteer_roles.view', 'volunteer_roles.create', 'volunteer_roles.edit',
            'volunteer_schedules.view', 'volunteer_schedules.create', 'volunteer_schedules.edit',
            'events.view', 'events.create', 'events.edit',
            'event_registrations.view', 'event_registrations.create', 'event_registrations.edit',
            'media.view', 'media.create', 'media.edit',
            'livestreams.view', 'livestreams.create',
            'members.view',
            'education.view', 'education.create', 'education.edit',
            'education_materials.view', 'education_materials.create', 'education_materials.edit',
            'education_classes.view', 'education_classes.create', 'education_classes.edit',
            'education_students.view', 'education_students.create', 'education_students.edit',
        ]);

        // Voluntário
        $voluntario = Role::where('name', 'Voluntário')->first();
        $voluntario?->givePermissionTo([
            'dashboard.view',
            'ministerios_atividades.view',
            'worship_songs.view',
            'worship_setlists.view',
            'worship_rehearsals.view',
            'events.view',
            'event_registrations.view',
            'volunteer_schedules.view',
        ]);

        // Usuário Comum
        $usuarioComum = Role::where('name', 'Usuário Comum')->first();
        $usuarioComum?->givePermissionTo([
            'dashboard.view',
            'comunicacao_evangelismo.view',
            'social_posts.view',
            'media.view',
            'events.view',
            'announcements.view',
        ]);

        // Administrador de TI
        $adminTI = Role::where('name', 'Administrador de TI')->first();
        $adminTI?->givePermissionTo([
            'dashboard.view',
            'logs_erros.view', 'logs_erros.create', 'logs_erros.edit', 'logs_erros.delete', 'logs_erros.approve',
            'qualidade_codigo.view', 'qualidade_codigo.create',
            'db_inspector.view',
            'tecnologia_informacao.view', 'tecnologia_informacao.create', 'tecnologia_informacao.edit',
            'security_incidents.view', 'security_incidents.create', 'security_incidents.edit',
            'system_access.view',
            'infrastructure.view', 'infrastructure.create', 'infrastructure.edit',
            'users.view', 'users.create', 'users.edit', 'users.delete',
        ]);

        // Analista de Logs
        $analistaLogs = Role::where('name', 'Analista de Logs')->first();
        $analistaLogs?->givePermissionTo([
            'dashboard.view',
            'logs_erros.view', 'logs_erros.edit',
            'system_access.view',
        ]);

        // Auditor Jurídico
        $auditorJuridico = Role::where('name', 'Auditor Jurídico')->first();
        $auditorJuridico?->givePermissionTo([
            'dashboard.view',
            'logs_erros.view',
            'juridico_compliance.view',
            'legal_documents.view',
            'compliance_obligations.view',
            'financial_audits.view',
            'fiscal_council_meetings.view',
        ]);
    }
}
