<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\InfoProductDTO;
use App\Http\Controllers\Controller;
use App\Services\Admin\InfoProduct\InfoProductService;
use App\Http\Requests\Admin\InfoProductRequest;
use App\Services\Common\FileHandler\FileHandlerService;
use Illuminate\Support\Carbon;

class InfoProductController extends Controller
{
    public InfoProductService $infoProductService;
    public FileHandlerService $fileHandlerService;

    public function __construct(InfoProductService $infoProductService, FileHandlerService $fileHandlerService)
    {
        $this->infoProductService = $infoProductService;
        $this->fileHandlerService = $fileHandlerService;
    }

    public function index()
    {
        $infoProducts = $this->infoProductService->getAllInfoProduct(
            [
                'id',
                'product_key',
                'product_name',
                'updated_at',
            ]
        );
        return view('Admin.Pages.Product.Info-Product.index', compact('infoProducts'));
    }

    public function create()
    {
        return view('Admin.Pages.Product.Info-Product.create');
    }

    public function store(InfoProductRequest $request)
    {
        try {
            $request->validated();
            $file = $request->file('product_image');
            $file_name = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            $path = 'product';

            $uploadedFile = $this->fileHandlerService->uploadFile($file, $path, $file_name);
            $this->infoProductService->createInfoProduct(new InfoProductDTO(
                $request->product_name,
                $request->product_key,
                $uploadedFile,
                $request->product_description
            ));
            return response()->json(['message' => 'Product created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $infoProduct = $this->infoProductService->getInfoProduct($id);
        $infoProduct->image = $this->fileHandlerService->getFile($infoProduct->image);
        return view('Admin.Pages.Product.Info-Product.update', compact('infoProduct'));
    }

    public function update(InfoProductRequest $request, $id)
    {
        try {
            $request->validated();
            $infoProduct = $this->infoProductService->getInfoProduct($id);
            $file = $request->file('product_image');
            if ($file) {
                $this->fileHandlerService->deleteFile($infoProduct->image);
                $file_name = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                $path = 'product';
                $uploadedFile = $this->fileHandlerService->uploadFile($file, $path, $file_name);
            } else {
                $uploadedFile = $infoProduct->image;
            }
            $this->infoProductService->updateInfoProduct(new InfoProductDTO(
                $request->product_name,
                $request->product_key,
                $uploadedFile,
                $request->product_description
            ), $id);
            return response()->json(['message' => 'Product updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $infoProduct = $this->infoProductService->getInfoProduct($id);
            $this->fileHandlerService->deleteFile($infoProduct->image);
            $this->infoProductService->deleteInfoProduct($id);
            return response()->json(['message' => 'Product deleted successfully'], 200);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
