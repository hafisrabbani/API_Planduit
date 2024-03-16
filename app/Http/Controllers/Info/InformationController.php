<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Hook\HookGrainAPI\HookGrainAPIService;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use App\Services\Admin\InfoProduct\InfoProductService;
use App\Services\Common\FileHandler\FileHandlerService;
class InformationController extends Controller
{
    private HookGoldAPIService $hookGoldAPIService;
    private HookGrainAPIService $hookGrainAPIService;
    private InfoProductService $infoProductService;
    private FileHandlerService $fileHandlerService;

    public function __construct(
        HookGoldAPIService $hookGoldAPIService,
        HookGrainAPIService $hookGrainAPIService,
        InfoProductService $infoProductService,
        FileHandlerService $fileHandlerService
    )
    {
        $this->hookGoldAPIService = $hookGoldAPIService;
        $this->hookGrainAPIService = $hookGrainAPIService;
        $this->infoProductService = $infoProductService;
        $this->fileHandlerService = $fileHandlerService;
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


    public function getAllProduct(){
        try {
            $products = $this->infoProductService->getAllInfoProduct([
                'product_name',
                'product_key'
            ]);
            return response()->json([
                'message' => 'Success',
                'data' => $products
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function infoProductDetail($key){
        try {
            $product = $this->infoProductService->getInfoProductByProductKey($key,[
                'product_name',
                'product_key',
                'image',
                'description'
            ]);
            $product->image = $this->fileHandlerService->getFile($product->image);
            return response()->json([
                'message' => 'Success',
                'data' => $product
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
