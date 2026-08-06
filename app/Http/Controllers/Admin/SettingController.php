<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allAsArray();
        return view('admin.settings.index', ['settings' => $settings, 'admins' => User::role(['super_admin', 'owner'])->get()]);
    }

    public function update(Request $request)
    {
        $allowed = [
            'company_name', 'tagline', 'address', 'phone', 'whatsapp', 'email',
            'facebook', 'instagram', 'tiktok', 'youtube', 'twitter', 'working_hours',
            'open_time', 'bank_name', 'bank_account', 'bank_holder',
            'bank2_name', 'bank2_account', 'bank2_holder', 'map_embed',
        ];

        foreach ($allowed as $key) {
            if ($request->has($key)) {
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '')]);
            }
        }

        $this->log('update', 'setting', 'Pengaturan sistem diperbarui.');
        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan.');
    }
}