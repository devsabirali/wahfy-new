<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        Log::info('Settings grouped by category:', ['settings' => $settings->toArray()]);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token', '_method');
        Log::info('Updating settings:', ['settings' => $settings]);

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                if ($setting->type === 'file' && $request->hasFile($key)) {
                    // Delete old file if exists
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    // Store new file
                    $value = $request->file($key)->store('settings', 'public');
                }

                $setting->value = $value;
                $setting->updated_by = Auth::id();
                $setting->save();
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cache cleared successfully.');
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required',
            'type' => 'required|in:text,textarea,file,number,boolean',
            'group' => 'required',
            'label' => 'required',
            'description' => 'nullable'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('value') && $validated['type'] === 'file') {
            $validated['value'] = $request->file('value')->store('settings', 'public');
        }

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function updateSetting(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'value' => 'required',
            'type' => 'required|in:text,textarea,file,number,boolean',
            'group' => 'required',
            'label' => 'required',
            'description' => 'nullable'
        ]);

        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('value') && $validated['type'] === 'file') {
            // Delete old file if exists
            if ($setting->value) {
                Storage::disk('public')->delete($setting->value);
            }
            $validated['value'] = $request->file('value')->store('settings', 'public');
        }

        $setting->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }
}
