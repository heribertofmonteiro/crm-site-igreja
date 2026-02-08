<?php

namespace App\Providers;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AdminLTEConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Carregar configurações do banco de dados
        $this->loadSystemSettings();
    }

    /**
     * Carregar configurações do sistema do banco de dados
     */
    protected function loadSystemSettings(): void
    {
        try {
            // Verificar se a tabela existe
            if (!DB::connection()->getSchemaBuilder()->hasTable('system_settings')) {
                return;
            }

            // Ler configurações do banco
            $settings = DB::table('system_settings')
                ->whereIn('key', ['system_name', 'sidebar_text', 'logo_url'])
                ->pluck('value', 'key')
                ->toArray();

            // Atualizar título
            if (isset($settings['system_name'])) {
                Config::set('adminlte.title', $settings['system_name']);
            }

            // Atualizar logo da sidebar
            if (isset($settings['sidebar_text'])) {
                $logoHtml = '<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 800; font-size: 1.3rem; letter-spacing: 1px; text-shadow: none;">' 
                    . e($settings['sidebar_text']) 
                    . '</span>';
                Config::set('adminlte.logo', $logoHtml);
                Config::set('adminlte.logo_img_alt', $settings['sidebar_text']);
            }

        } catch (\Exception $e) {
            // Silentemente falhar se o banco não estiver disponível
            // As configurações padrão serão usadas
        }
    }
}
