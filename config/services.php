<?php

return [
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-3.8-flash'),
    ],
    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'verify_token' => env('WHATSAPP_VERIFY_TOKEN', 'avi_whatsapp_verify_token_2026'),
        'api_version' => env('WHATSAPP_API_VERSION', 'v21.0'),
        'central_number' => env('WHATSAPP_CENTRAL_NUMBER', '573000000000'),
    ],
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'default_chat_id' => env('TELEGRAM_CHAT_ID'),
    ],
    'ai_service' => [
        'url' => env('FASTAPI_AI_URL', env('AI_SERVICE_URL', 'http://avi-ai:8001')),
        'timeout' => (float) env('AI_SERVICE_TIMEOUT', 4.0),
    ],
];
