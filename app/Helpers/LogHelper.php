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
     * @param int|string $byId  Record ID of the user who deleted the record
     * @return void
     */
    public static function Log($action, $model, $id, $byId = null)
    {
        $log = [
            'action' => $action,
            'model' => $model,
            'id' => $id,
            'at' => now()->toDateTimeString(),
            'byId' => $byId,
        ];
        Log::channel('daily')->info('DATA_CHANGE', $log);
    }
}