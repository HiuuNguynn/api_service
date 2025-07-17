<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * Log data change actions
     *
     * @param string $action Action performed (created, updated, deleted...)
     * @param string $model  Model name (User, Person...)
     * @param int|string $id  Record ID
     * @param array|null $oldData Old data (if any)
     * @param array|null $newData New data (if any)
     * @param int|string|null $byUserId User ID who performed the action (if any)
     * @return void
     */
    public static function Log($action, $model, $id, $oldData = null, $newData = null, $byUserId = null)
    {
        $log = [
            'action' => $action,
            'model' => $model,
            'id' => $id,
            'by_user' => $byUserId,
            'old' => $oldData,
            'new' => $newData,
            'at' => now()->toDateTimeString(),
        ];
        Log::channel('api')->info('DATA_CHANGE', $log);
    }
}