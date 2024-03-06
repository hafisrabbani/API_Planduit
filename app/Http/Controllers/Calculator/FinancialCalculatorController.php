<?php

namespace App\Http\Controllers\Calculator;

use App\DTO\Budgeting503020;
use App\DTO\InvestmentDTO;
use App\DTO\ProfileResikoDTO;
use App\DTO\ZakatPenghasilanDTO;
use App\DTO\ZakatEmasDTO;
use App\DTO\ZakatTabunganDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calculator\BudgetingRequest;
use App\Http\Requests\Calculator\InvestmentRequest;
use App\Http\Requests\Calculator\ProfileResikoRequest;
use App\Http\Requests\Zakat\ZakatPenghasilanRequest;
use App\Http\Requests\Zakat\ZakatEmasRequest;
use App\Http\Requests\Calculator\ZakatTabunganRequest;
use App\Services\Calculator\Budgeting503020\Budgeting503020Service;
use App\Services\Calculator\InvestmentCalculator\InvestmentCalculatorService;
use App\Services\Calculator\ProfileResiko\ProfileResikoService;
use App\Services\Calculator\Zakat\ZakatPenghasilan\ZakatPenghasilanService;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use App\Services\Calculator\Zakat\ZakatEmas\ZakatEmasService;
use App\Services\Calculator\Zakat\ZakatTabungan\ZakatTabunganService;

class FinancialCalculatorController extends Controller
{
    private $investmentCalculatorService;
    private $budgeting503020Service;
    private $zakatPenghasilanService;
    private $hookGoldAPIService;
    private $profileResikoService;
    private $zakatEmasService;
    private $zakatTabunganService;
    public function __construct(
        InvestmentCalculatorService $investmentCalculatorService,
        Budgeting503020Service      $budgeting503020Service,
        ZakatPenghasilanService     $zakatPenghasilanService,
        HookGoldAPIService          $hookGoldAPIService,
        ProfileResikoService        $profileResikoService,
        ZakatEmasService            $zakatEmasService,
        ZakatTabunganService        $zakatTabunganService
    )
    {
        $this->investmentCalculatorService = $investmentCalculatorService;
        $this->budgeting503020Service = $budgeting503020Service;
        $this->zakatPenghasilanService = $zakatPenghasilanService;
        $this->hookGoldAPIService = $hookGoldAPIService;
        $this->profileResikoService = $profileResikoService;
        $this->zakatEmasService = $zakatEmasService;
        $this->zakatTabunganService = $zakatTabunganService;
    }

    /**
     * @throws \Exception
     */
    public function storeInvestment(InvestmentRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $investmentDTO = new InvestmentDTO($data['target_money'],
                $data['target_time'],
                $data['initial_money'],
                $data['money_investment'],
                $data['time_type'],
                $data['interest']
            );
            $result = $this->investmentCalculatorService->setData($investmentDTO)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeBudgeting503020(BudgetingRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $budgeting503020 = new Budgeting503020($data['income']);
            $result = $this->budgeting503020Service->setData($budgeting503020)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeZakatPenghasilan(ZakatPenghasilanRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $zakatPenghasilanDTO = new ZakatPenghasilanDTO(
                $data['income'],
                $data['another_income'],
                $data['expenditure'],
                $data['time_type'],
                $this->hookGoldAPIService->getGoldPrice()
            );
            $result = $this->zakatPenghasilanService->setData($zakatPenghasilanDTO)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getQuestionProfileResiko(): \Illuminate\Http\JsonResponse
    {
        try {
            $questionPATH = public_path('data/question.json');
            $question = json_decode(file_get_contents($questionPATH), true);
            return response()->json([
                'message' => 'Success',
                'data' => $question
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeProfileResiko(ProfileResikoRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $profileResikoDTO = new ProfileResikoDTO($data['answers']);
            $result = $this->profileResikoService->setData($profileResikoDTO)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeZakatEmas(ZakatEmasRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $zakatEmasDTO = new ZakatEmasDTO(
                $data['weight'],
                $this->hookGoldAPIService->getGoldPrice()
            );
            $result = $this->zakatEmasService->setData($zakatEmasDTO)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeZakatTabungan(ZakatTabunganRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $zakatTabunganDTO = new ZakatTabunganDTO(
                $data['savings'],
                $data['interest'] ?? 0,
                $this->hookGoldAPIService->getGoldPrice(),
                $data['bank']
            );
            $result = $this->zakatTabunganService->setData($zakatTabunganDTO)->getResults();
            return response()->json([
                'message' => 'Success',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
