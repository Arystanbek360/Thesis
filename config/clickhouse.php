<?php

return [
    'host'     => env('CLICKHOUSE_HOST', '127.0.0.1'),
    'port'     => env('CLICKHOUSE_PORT', 8123),
    'username' => env('CLICKHOUSE_USERNAME', 'default'),
    'password' => env('CLICKHOUSE_PASSWORD', '1234'),
    'https'    => env('CLICKHOUSE_HTTPS', false),
    'database' => env('CLICKHOUSE_DATABASE', 'default'),
];
