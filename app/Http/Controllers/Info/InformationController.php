<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Hook\HookGrainAPI\HookGrainAPIService;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;

class InformationController extends Controller
{
    private HookGoldAPIService $hookGoldAPIService;
    private HookGrainAPIService $hookGrainAPIService;

    public function __construct(
        HookGoldAPIService $hookGoldAPIService,
        HookGrainAPIService $hookGrainAPIService
    )
    {
        $this->hookGoldAPIService = $hookGoldAPIService;
        $this->hookGrainAPIService = $hookGrainAPIService;
    }

    public function infoGoldPrice(): \Illuminate\Http\JsonResponse
    {
        try {
            $goldPrice = $this->hookGoldAPIService->getGoldPrice();
            return response()->json([
                'message' => 'Success',
                'data' => [
                    'gold_price' => $goldPrice,
                ]
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function infoGrainPrice(): \Illuminate\Http\JsonResponse
    {
        try {
            $grainPrice = $this->hookGrainAPIService->getGrainPrice();
            return response()->json([
                'message' => 'Success',
                'data' => [
                    'grain_price' => $grainPrice,
                ]
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
