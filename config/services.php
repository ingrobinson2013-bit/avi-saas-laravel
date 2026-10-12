<?php

return [
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY') ?: 'AIzaSyBBRdG67yYvFblN7xR_Q3HkVfQOsnWl1hk',
        'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
    ],
];
