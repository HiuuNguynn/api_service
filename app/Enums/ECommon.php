<?php

namespace App\Enums;

class ECommon
{
    const BUILDER_TYPE_ELOQUENT = 1;
    const BUILDER_TYPE_QUERY = 2;

    const RESPONSE_CODE_SUCCESS = 'OK';
    const RESPONSE_CODE_FAILURE = 'FAILURE';

    const MASKED_KEY = [];

    const LOG_CHANNEL_API = 'api';
    const LOG_CHANNEL_ERROR = 'error';
    const LOG_CHANNEL_SQL = 'sql';
}
