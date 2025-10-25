<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class GeneralHelper
{
    /**
     * Get general website setting by key
     *
     * @param string $key The setting key (e.g., 'contact_phone', 'logo', 'address')
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    public static function getSetting($key, $default = null)
    {
        // Try to get from cache first
        $settings = Cache::remember('general_settings', 3600, function () {
            return Setting::all();
        });

        $setting = $settings->firstWhere('key', $key);

        return $setting ? $setting->value : $default;
    }

    /**
     * Get phone number
     *
     * @return string
     */
    public static function getPhone()
    {
        return self::getSetting('contact_phone', '+44 204 577 0077');
    }


    public static function get_description()
    {
        return self::getSetting('site_description', 'wahfy is ngo');
    }

    /**
     * Get email address
     *
     * @return string
     */
    public static function getEmail()
    {
        return self::getSetting('contact_email', 'contact@example.com');
    }

    /**
     * Get address
     *
     * @return string
     */
    public static function getAddress()
    {
        return self::getSetting('address', 'Washington Ave, NY');
    }

    /**
     * Get logo
     *
     * @return string
     */
    public static function getLogo()
    {
        return self::getSetting('logo', 'default-logo.png');
    }

    /**
     * Get favicon
     *
     * @return string
     */
    public static function getFavicon()
    {
        return self::getSetting('favicon', 'default-favicon.ico');
    }

    public static function getStaticData($filename)
    {
        $path = resource_path('static/' . $filename . '.json');
        if (!file_exists($path)) return null;
        return json_decode(file_get_contents($path), true);
    }

    /**
     * Get static data from a JSON file in resources/static/
     * Usage: GeneralHelper::static('about', 'vision')
     *
     * @param string $file The JSON file name (without .json)
     * @param string|null $key The key to retrieve (optional)
     * @return mixed|null
     */
    public static function static($file, $key = null)
    {
        $path = resource_path('static/' . $file . '.json');
        if (!file_exists($path)) return null;
        $data = json_decode(file_get_contents($path), true);
        if ($key === null) return $data;
        return $data[$key] ?? null;
    }
}
