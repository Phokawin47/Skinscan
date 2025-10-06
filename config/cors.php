<?php

return [

    'supports_credentials' => true,
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_origins' => ['http://10.225.0.13:5173','http://10.225.0.13:8000'],
    'allowed_headers' => ['*'],
    'allowed_methods' => ['*'],
];
