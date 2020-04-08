<?php

namespace App\Libraries;

class CacheKeys
{
    public static function getDashboardUserIdsByProgramId($programId)
    {
        return 'programs:' . $programId . ':dashboardUsers';
    }

    public static function getUserNotificationKey($userId)
    {
        return 'users:' . $userId . ':notifications';
    }
}
