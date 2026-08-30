<?php

use App\Services\FastApiClient;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});

Route::post('/ai/recommend-plan', function (Request $request, FastApiClient $aiClient) {
    $species = $request->input('species', 'dog');
    $ageMonths = (int) $request->input('age_months', 12);
    $conditions = (array) $request->input('health_conditions', []);
    $budget = $request->input('budget_tier', 'medium');

    return response()->json($aiClient->recommendPlan($species, $ageMonths, $conditions, $budget));
});

Route::post('/webhooks/payment/{gateway}', function (Request $request, string $gateway, PaymentGatewayService $paymentService) {
    $subscription = $paymentService->handleSuccessfulPayment($request->all(), $gateway);
    return response()->json(['status' => 'processed', 'subscription_id' => $subscription->id]);
});
