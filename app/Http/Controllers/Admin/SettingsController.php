<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = SystemSetting::allAsArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'nullable|string|max:255',
            'church_name' => 'nullable|string|max:255',
            'sidebar_text' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ]);

        // Update text settings
        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value, 'string', ucfirst(str_replace('_', ' ', $key)));
        }

        // Clear all settings cache
        SystemSetting::clearCache();
        Cache::flush();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Upload a new logo.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Delete old logo if exists
        $oldLogo = SystemSetting::get('logo_path');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        // Store new logo
        $logo = $request->file('logo');
        $logoPath = $logo->store('logos', 'public');

        // Generate URL
        $logoUrl = Storage::url($logoPath);

        // Save setting
        SystemSetting::set('logo_path', $logoPath, 'string', 'Caminho da logo da igreja');
        SystemSetting::set('logo_url', $logoUrl, 'string', 'URL pública da logo');

        // Clear cache
        SystemSetting::clearCache();
        Cache::flush();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Logo enviada com sucesso!');
    }

    /**
     * Delete the current logo.
     */
    public function deleteLogo()
    {
        $logoPath = SystemSetting::get('logo_path');

        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            Storage::disk('public')->delete($logoPath);
        }

        // Remove settings
        SystemSetting::where('key', 'logo_path')->delete();
        SystemSetting::where('key', 'logo_url')->delete();

        // Clear cache
        SystemSetting::clearCache();
        Cache::flush();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Logo removida com sucesso!');
    }

    /**
     * Reset settings to default values.
     */
    public function resetToDefaults()
    {
        $defaultSettings = [
            'system_name' => 'Igreja On Line',
            'sidebar_text' => 'Igreja On Line',
            'logo_path' => null,
            'logo_url' => null,
        ];

        foreach ($defaultSettings as $key => $value) {
            SystemSetting::set($key, $value, 'string', ucfirst(str_replace('_', ' ', $key)));
        }

        // Clear cache
        SystemSetting::clearCache();
        Cache::flush();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Configurações restauradas para os valores padrão!');
    }
}
