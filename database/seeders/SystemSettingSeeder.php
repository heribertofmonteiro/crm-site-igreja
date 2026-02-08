<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Sistema
            [
                'key' => 'system_name',
                'value' => 'Igreja On Line',
                'type' => 'string',
                'description' => 'Nome do sistema exibido no título e interface',
            ],
            [
                'key' => 'sidebar_text',
                'value' => 'Igreja On Line',
                'type' => 'string',
                'description' => 'Texto exibido na sidebar do painel administrativo',
            ],

            // Logo
            [
                'key' => 'logo_path',
                'value' => null,
                'type' => 'string',
                'description' => 'Caminho local para a logo da igreja',
            ],
            [
                'key' => 'logo_url',
                'value' => null,
                'type' => 'string',
                'description' => 'URL pública da logo da igreja',
            ],

            // Igreja
            [
                'key' => 'church_name',
                'value' => '',
                'type' => 'string',
                'description' => 'Nome oficial da igreja',
            ],
            [
                'key' => 'contact_email',
                'value' => '',
                'type' => 'string',
                'description' => 'E-mail de contato da igreja',
            ],
            [
                'key' => 'contact_phone',
                'value' => '',
                'type' => 'string',
                'description' => 'Telefone de contato da igreja',
            ],
            [
                'key' => 'address',
                'value' => '',
                'type' => 'string',
                'description' => 'Endereço físico da igreja',
            ],

            // Configurações Regionais
            [
                'key' => 'timezone',
                'value' => 'America/Sao_Paulo',
                'type' => 'string',
                'description' => 'Fuso horário do sistema',
            ],
            [
                'key' => 'date_format',
                'value' => 'd/m/Y',
                'type' => 'string',
                'description' => 'Formato de data',
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i',
                'type' => 'string',
                'description' => 'Formato de hora',
            ],
            [
                'key' => 'currency',
                'value' => 'BRL',
                'type' => 'string',
                'description' => 'Moeda padrão',
            ],

            // Configurações de Sessão
            [
                'key' => 'session_timeout',
                'value' => '120',
                'type' => 'integer',
                'description' => 'Tempo limite de sessão em minutos',
            ],

            // Configurações de Manutenção
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Ativar modo de manutenção',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Sistema em manutenção. Tente novamente mais tarde.',
                'type' => 'string',
                'description' => 'Mensagem exibida durante manutenção',
            ],

            // Configurações de E-mail
            [
                'key' => 'noreply_email',
                'value' => 'noreply@igreja.com.br',
                'type' => 'string',
                'description' => 'E-mail para envios automáticos',
            ],
            [
                'key' => 'email_sender_name',
                'value' => 'Igreja On Line',
                'type' => 'string',
                'description' => 'Nome do remetente para e-mails',
            ],

            // Configurações de Backup
            [
                'key' => 'backup_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Ativar backups automáticos',
            ],
            [
                'key' => 'backup_frequency',
                'value' => 'daily',
                'type' => 'string',
                'description' => 'Frequência de backups (daily, weekly, monthly)',
            ],
            [
                'key' => 'backup_retention',
                'value' => '7',
                'type' => 'integer',
                'description' => 'Número de dias para retenção de backups',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Configurações do sistema criadas com sucesso!');
    }
}
