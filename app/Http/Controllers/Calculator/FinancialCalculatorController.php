<?php

namespace App\Http\Controllers\Calculator;

use App\DTO\Budgeting503020;
use App\DTO\InvestmentDTO;
use App\DTO\ProfileResikoDTO;
use App\DTO\ZakatEmasDTO;
use App\DTO\ZakatPenghasilanDTO;
use App\DTO\ZakatPerdaganganDTO;
use App\DTO\ZakatPertanianDTO;
use App\DTO\ZakatTabunganDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calculator\BudgetingRequest;
use App\Http\Requests\Calculator\InvestmentRequest;
use App\Http\Requests\Calculator\ProfileResikoRequest;
use App\Http\Requests\Calculator\ZakatTabunganRequest;
use App\Http\Requests\Zakat\ZakatEmasRequest;
use App\Http\Requests\Zakat\ZakatPenghasilanRequest;
use App\Http\Requests\Zakat\ZakatPerdaganganRequest;
use App\Http\Requests\Zakat\ZakatPertanianRequest;
use App\Services\Calculator\Budgeting503020\Budgeting503020Service;
use App\Services\Calculator\InvestmentCalculator\InvestmentCalculatorService;
use App\Services\Calculator\ProfileResiko\ProfileResikoService;
use App\Services\Calculator\Zakat\ZakatEmas\ZakatEmasService;
use App\Services\Calculator\Zakat\ZakatPenghasilan\ZakatPenghasilanService;
use App\Services\Calculator\Zakat\ZakatPerdagangan\ZakatPerdaganganService;
use App\Services\Calculator\Zakat\ZakatPertanian\ZakatPertanianService;
use App\Services\Calculator\Zakat\ZakatTabungan\ZakatTabunganService;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use App\Services\Hook\HookGrainAPI\HookGrainAPIService;

/**
 *
 */
class FinancialCalculatorController extends Controller
{
    /**
     * @var InvestmentCalculatorService
     */
    private $investmentCalculatorService;
    /**
     * @var Budgeting503020Service
     */
    private $budgeting503020Service;
    /**
     * @var ZakatPenghasilanService
     */
    private $zakatPenghasilanService;
    /**
     * @var HookGoldAPIService
     */
    private $hookGoldAPIService;
    /**
     * @var ProfileResikoService
     */
    private $profileResikoService;
    /**
     * @var ZakatEmasService
     */
    private $zakatEmasService;
    /**
     * @var ZakatTabunganService
     */
    private $zakatTabunganService;
    /**
     * @var ZakatPertanianService
     */
    private $zakatPertanianService;
    /**
     * @var HookGrainAPIService
     */
    private $hookGrainAPIService;

    /**
     * @var ZakatPerdaganganService
     */
    private $zakatPerdaganganService;
    /**
     * @param InvestmentCalculatorService $investmentCalculatorService
     * @param Budgeting503020Service $budgeting503020Service
     * @param ZakatPenghasilanService $zakatPenghasilanService
     * @param HookGoldAPIService $hookGoldAPIService
     * @param ProfileResikoService $profileResikoService
     * @param ZakatEmasService $zakatEmasService
     * @param ZakatTabunganService $zakatTabunganService
     * @param ZakatPertanianService $zakatPertanianService
     * @param HookGrainAPIService $hookGrainAPIService
     * @param ZakatPerdaganganService $zakatPerdaganganService
     *
     */
    public function __construct(
        InvestmentCalculatorService $investmentCalculatorService,
        Budgeting503020Service      $budgeting503020Service,
        ZakatPenghasilanService     $zakatPenghasilanService,
        HookGoldAPIService          $hookGoldAPIService,
        ProfileResikoService        $profileResikoService,
        ZakatEmasService            $zakatEmasService,
        ZakatTabunganService        $zakatTabunganService,
        ZakatPertanianService       $zakatPertanianService,
        HookGrainAPIService         $hookGrainAPIService,
        ZakatPerdaganganService     $zakatPerdaganganService
    )
    {
        $this->investmentCalculatorService = $investmentCalculatorService;
        $this->budgeting503020Service = $budgeting503020Service;
        $this->zakatPenghasilanService = $zakatPenghasilanService;
        $this->hookGoldAPIService = $hookGoldAPIService;
        $this->profileResikoService = $profileResikoService;
        $this->zakatEmasService = $zakatEmasService;
        $this->zakatTabunganService = $zakatTabunganService;
        $this->zakatPertanianService = $zakatPertanianService;
        $this->hookGrainAPIService = $hookGrainAPIService;
        $this->zakatPerdaganganService = $zakatPerdaganganService;
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

    /**
     * @param BudgetingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param ZakatPenghasilanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param ProfileResikoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param ZakatEmasRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param ZakatTabunganRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param ZakatPertanianRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeZakatPertanian(ZakatPertanianRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->validated();
            $grainPrice = isset($data['grain_price']) && $data['grain_price'] > 0 ? $data['grain_price'] : $this->hookGrainAPIService->getGrainPrice();
            $zakatPertanianDTO = new ZakatPertanianDTO(
                $data['total_harvest'],
                $data['is_watered'],
                $grainPrice
            );
            $result = $this->zakatPertanianService->setData($zakatPertanianDTO)->getResults();
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

    public function storeZakatPerdagangan(ZakatPerdaganganRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->all();
            $goldPrice = $this->hookGoldAPIService->getGoldPrice();
            $zakatPerdaganganDTO = new ZakatPerdaganganDTO(
                $data['rotated_capital'],
                $data['current_recievable'],
                $data['profit'],
                $data['current_payable'],
                $data['loss']
            );
            $result = $this->zakatPerdaganganService->setData($zakatPerdaganganDTO, $goldPrice)->getResults();
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
