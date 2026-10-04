<?php

namespace App\Http\Controllers\VetAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Services\GeminiClinicAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    public function __construct(
        protected GeminiClinicAssistantService $geminiService
    ) {}

    public function chat(Request $request, string $slug): JsonResponse
    {
        $tenant = Tenant::where('slug', $slug)->first() ?? Tenant::first();
        if (!$tenant) {
            return response()->json([
                'success' => false,
                'error' => 'Clínica no encontrada',
            ], 404);
        }

        $raw = json_decode($request->getContent(), true);
        $prompt = trim($request->input('message') ?? ($raw['message'] ?? '') ?? $request->get('message') ?? '');
        if (empty($prompt)) {
            return response()->json([
                'success' => false,
                'error' => 'El mensaje es requerido',
            ], 422);
        }
        $user = auth()->user();

        $result = $this->geminiService->ask($prompt, $tenant, $user);

        return response()->json($result);
    }
}
