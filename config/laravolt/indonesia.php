<?php

return [
    'table_prefix' => 'indonesia_',
    'route' => [
        'enabled' => false,
        'middleware' => ['web', 'auth', 'api'],
        'prefix' => 'indonesia',
    ],
    'view' => [
        'layout' => 'ui::layouts.app',
    ],
    'menu' => [
        'enabled' => false,
    ],
    // 'indonesia' => [
    //     'table_prefix' => 'id_',
    // ],
];
