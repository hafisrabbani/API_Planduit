<?php

namespace App\Http\Controllers\Test;

use App\DTO\InvestmentDTO;
use App\Http\Controllers\Controller;
use App\Services\Calculator\InvestmentCalculator\InvestmentCalculatorService;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use App\Services\Hook\HookGrainAPI\HookGrainAPIService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

//use App\Services\InvestmentCalculator\InvestmentCalculatorService;
//use App\Services\InvestmentCalculator\InvestmentRecommendationService;

class TestingController extends Controller
{
    private HookGoldAPIService $hookGoldAPIService;
    private InvestmentCalculatorService $investmentCalculatorService;


    public function __construct(
        HookGoldAPIService $hookGoldAPIService,
        InvestmentCalculatorService $investmentCalculatorService,
        HookGrainAPIService $hookGrainAPIService
    )
    {
        $this->hookGoldAPIService = $hookGoldAPIService;
        $this->investmentCalculatorService = $investmentCalculatorService;
        $this->hookGrainAPIService = $hookGrainAPIService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
//            $client = new Client();
            $grainPrice = $this->hookGrainAPIService->getGrainPrice();
            $goldPrice = $this->hookGoldAPIService->getGoldPrice();
            return response()->json([
                'message' => 'Success',
                'data' => [
                    'gold_price' => $goldPrice,
                    'grain_price' => $grainPrice
                ]
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

//    public function calculateInvestment(Request $request): \Illuminate\Http\JsonResponse
//    {
//        try {
//
////            $investment = $this->investmentCalculatorService->setInvestment(
////                10000000,
////                5,
////                2000000,
////                1500000,
////                'YEARLY',
////                2)->calculateResult();
////
//            $investment = $this->investmentCalculatorService->setInvestment(
//                10000000,
//                1,
//                1000000,
//                200000,
//                'MONTHLY',
//                10)->calculateResult();
//
////            $investment = $this->investmentCalculatorService->setInvestment(
////                10000000,
////                3,
////                1000000,
////                500000,
////                'MONTHLY',
////                10)->calculateResult();
//
////            dd($investment->getResults());
//
//            return response()->json([
//                'message' => 'Success',
//                'data' => [
//                    'investment' => $investment->getResults()
//                ]
//            ], 200);
//        }catch (\Exception $e) {
//            return response()->json([
//                'message' => $e->getMessage()
//            ], 500);
//        }
//    }

    public function calculateInvestment(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $investment = $this->investmentCalculatorService->setData(
                new InvestmentDTO(
                    10000000,
                    1,
                    1000000,
                    700000,
                    'MONTHLY',
                    10
                )
            );

            return response()->json([
                'message' => 'Success',
                'data' => [
                    'investment' => $investment->getResults()
                ]
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
