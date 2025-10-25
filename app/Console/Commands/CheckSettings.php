<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class CheckSettings extends Command
{
    protected $signature = 'settings:check';
    protected $description = 'Check the settings in the database';

    public function handle()
    {
        $settings = Setting::all();

        if ($settings->isEmpty()) {
            $this->error('No settings found in the database!');
            return;
        }

        $this->info('Found ' . $settings->count() . ' settings:');

        foreach ($settings as $setting) {
            $this->line(sprintf(
                "Key: %-20s | Value: %-30s | Group: %-10s | Type: %-10s | Required: %s",
                $setting->key,
                $setting->value,
                $setting->group,
                $setting->type,
                $setting->is_required ? 'Yes' : 'No'
            ));
        }
    }
}
