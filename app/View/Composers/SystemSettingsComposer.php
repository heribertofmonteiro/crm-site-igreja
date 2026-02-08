<?php

namespace App\View\Composers;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SystemSettingsComposer
{
    /**
     * The settings that should be loaded.
     */
    protected array $settings = [
        'system_name',
        'sidebar_text',
        'logo_path',
        'logo_url',
        'church_name',
        'contact_email',
        'contact_phone',
        'address',
    ];

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $settings = [];

        foreach ($this->settings as $key) {
            $settings[$key] = SystemSetting::get($key, $this->getDefaultValue($key));
        }

        // Add defaults if not found
        $settings['system_name'] = $settings['system_name'] ?? 'Igreja On Line';
        $settings['sidebar_text'] = $settings['sidebar_text'] ?? 'Igreja On Line';
        $settings['logo_path'] = $settings['logo_path'] ?? null;
        $settings['logo_url'] = $settings['logo_url'] ?? null;
        $settings['church_name'] = $settings['church_name'] ?? '';
        $settings['contact_email'] = $settings['contact_email'] ?? '';
        $settings['contact_phone'] = $settings['contact_phone'] ?? '';
        $settings['address'] = $settings['address'] ?? '';

        $view->with('system_settings', $settings);
    }

    /**
     * Get default value for a setting.
     */
    protected function getDefaultValue(string $key): mixed
    {
        return match ($key) {
            'system_name' => 'Igreja On Line',
            'sidebar_text' => 'Igreja On Line',
            'logo_path' => null,
            'logo_url' => null,
            'church_name' => '',
            'contact_email' => '',
            'contact_phone' => '',
            'address' => '',
            default => null,
        };
    }
}
