<?php

use App\Models\SystemSetting;

/**
 * Get a system setting value by key.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return SystemSetting::get($key, $default);
    }
}

/**
 * Get system name.
 */
if (!function_exists('system_name')) {
    function system_name(): string
    {
        return SystemSetting::get('system_name', 'Igreja On Line');
    }
}

/**
 * Get sidebar text.
 */
if (!function_exists('sidebar_text')) {
    function sidebar_text(): string
    {
        return SystemSetting::get('sidebar_text', 'Igreja On Line');
    }
}

/**
 * Get logo URL.
 */
if (!function_exists('logo_url')) {
    function logo_url(): ?string
    {
        return SystemSetting::get('logo_url');
    }
}

/**
 * Get church name.
 */
if (!function_exists('church_name')) {
    function church_name(): string
    {
        return SystemSetting::get('church_name', '');
    }
}

/**
 * Get contact email.
 */
if (!function_exists('contact_email')) {
    function contact_email(): string
    {
        return SystemSetting::get('contact_email', '');
    }
}

/**
 * Get contact phone.
 */
if (!function_exists('contact_phone')) {
    function contact_phone(): string
    {
        return SystemSetting::get('contact_phone', '');
    }
}

/**
 * Get address.
 */
if (!function_exists('church_address')) {
    function church_address(): string
    {
        return SystemSetting::get('address', '');
    }
}
