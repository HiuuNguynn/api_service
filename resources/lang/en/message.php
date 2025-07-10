<?php

return [
    'error' => [
        'common' => [
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '405' => 'Method Not Allowed',
            '406' => 'Not Acceptable',
            '422' => 'Unprocessable Entity',
            '500' => 'Internal Server Error',
        ],
        'function' => [
            'not_found' => 'Function not found',
        ],
        'project' => [
            'not_acceptable' => 'Project not found',
        ],
    ],
    'success' => [
        'performance' => [
            'list' => 'Get performance of project successful',
            'import' => 'Import performance of project successful',
        ],
        'function' => [
            'create' => 'Create function successful',
            'list' => 'Get functions successful',
            'detail' => 'Get function detail successful',
            'update' => 'Update function successful',
            'delete' => 'Delete function successful',
        ],
    ],
];
