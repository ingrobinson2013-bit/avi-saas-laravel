<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'platform' => 'AVI SaaS Platform',
        'status' => 'online',
        'version' => '1.0.0',
        'admin_url' => url('/admin'),
        'super_admin_url' => url('/super-admin'),
    ]);
});
