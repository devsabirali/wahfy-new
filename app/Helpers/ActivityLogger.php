<?php
namespace App\Helpers;

use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log a user activity.
     *
     * @param string $activityType
     * @param string $description
     * @param int|null $userId
     * @return void
     */
    public static function log($activityType, $description, $userId = null)
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : null);
        UserActivityLog::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
