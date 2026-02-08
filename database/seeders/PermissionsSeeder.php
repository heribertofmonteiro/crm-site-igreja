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
        // Módulos do sistema baseados nos controllers existentes
        $modules = [
            // Core
            'dashboard',
            'members',
            'users',
            
            // Governança Pastoral
            'governanca_pastoral',
            'doctrines',
            'pastoral_councils',
            'pastoral_notes',
            
            // Administração Geral
            'administracao_geral',
            'departments',
            'announcements',
            'documents',
            'meeting_minutes',
            
            // Gestão de Pessoas
            'gestao_pessoas_lideranca',
            'volunteer_roles',
            'volunteer_schedules',
            
            // Ministérios e Atividades
            'ministerios_atividades',
            'worship_songs',
            'worship_setlists',
            'worship_teams',
            'worship_rehearsals',
            
            // Comunicação e Evangelismo
            'comunicacao_evangelismo',
            'social_posts',
            'media',
            'livestreams',
            
            // Eventos
            'eventos_programacao',
            'events',
            'event_venues',
            'event_registrations',
            'event_resources',
            
            // Gestão Financeira
            'gestao_financeira',
            'financial_accounts',
            'financial_transactions',
            'transaction_categories',
            'budgets',
            'financial_reports',
            'financial_audits',
            'fiscal_council_meetings',
            'donations',
            
            // Patrimônio
            'patrimonio_infraestrutura',
            'assets',
            'maintenance_orders',
            'space_bookings',
            'infrastructure',
            
            // Ação Social
            'acao_social_diaconia',
            'social_projects',
            'social_volunteers',
            'social_assistance',
            
            // Educação
            'education',
            'education_materials',
            'education_classes',
            'education_students',
            
            // Missões
            'missions',
            'missionaries',
            'mission_projects',
            'mission_supports',
            
            // Jurídico
            'juridico_compliance',
            'legal_documents',
            'lgpd_consents',
            'compliance_obligations',
            
            // TI
            'tecnologia_informacao',
            'security_incidents',
            'system_access',
            
            // Logs e Qualidade
            'logs_erros',
            'qualidade_codigo',
            'db_inspector',
        ];

        $actions = ['view', 'create', 'edit', 'delete', 'approve'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $module . '.' . $action]);
            }
        }
    }
}
