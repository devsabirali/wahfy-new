<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'logo',
                'value' => 'assets/img/logo.svg',
                'type' => 'file',
                'group' => 'media',
                'label' => 'Site Logo',
                'description' => 'The main logo of the website',
                'is_required' => false,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'key' => 'favicon',
                'value' => 'assets/img/favicon.ico',
                'type' => 'file',
                'group' => 'media',
                'label' => 'Site Favicon',
                'description' => 'The favicon of the website',
                'is_required' => false,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
