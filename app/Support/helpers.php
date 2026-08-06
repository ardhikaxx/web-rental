<?php

use App\Models\SiteSetting;
use App\Models\User;

if (! function_exists('site_key')) {
    function site_key(string $key, ?string $default = null): ?string
    {
        return SiteSetting::getSetting($key, $default);
    }
}

if (! function_exists('rupiah')) {
    function rupiah($amount, bool $decimals = true): string
    {
        $amount = (float) $amount;
        if (! $decimals || $amount == (int) $amount) {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
        return 'Rp ' . number_format($amount, 2, ',', '.');
    }
}

if (! function_exists('format_indo_date')) {
    function format_indo_date($date): string
    {
        if (! $date) {
            return '-';
        }
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i');
    }
}