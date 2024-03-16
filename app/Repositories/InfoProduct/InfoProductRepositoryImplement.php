<?php

namespace App\Repositories\InfoProduct;

use App\DTO\Admin\InfoProductDTO;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\InfoProduct;

class InfoProductRepositoryImplement extends Eloquent implements InfoProductRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    public function __construct(InfoProduct $model)
    {
        $this->model = $model;
    }

    public function creatInfoProduct(InfoProductDTO $infoProductDTO)
    {
        try {
            $infoProduct = new InfoProduct();
            $infoProduct->product_name = $infoProductDTO->product_name;
            $infoProduct->product_key = $infoProductDTO->product_key;
            $infoProduct->image = $infoProductDTO->image;
            $infoProduct->description = $infoProductDTO->description;
            $infoProduct->save();
            return $infoProduct;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateInfoProduct(InfoProductDTO $infoProductDTO, int $id)
    {
        try {
            $infoProduct = InfoProduct::findOrfail($id);
            $infoProduct->product_name = $infoProductDTO->product_name;
            $infoProduct->product_key = $infoProductDTO->product_key;
            $infoProduct->image = $infoProductDTO->image;
            $infoProduct->description = $infoProductDTO->description;
            $infoProduct->save();
            return $infoProduct;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteInfoProduct(int $id)
    {
        try {
            $infoProduct = InfoProduct::findOrfail($id);
            $infoProduct->delete();
            return $infoProduct;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getInfoProduct(int $id, $columns = ['*'])
    {
        try {
            return InfoProduct::findOrfail($id, $columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllInfoProduct($columns = ['*'], $callback = null)
    {
        try {
            return InfoProduct::select($columns)->when($callback, $callback)->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getInfoProductByProductKey(string $product_key, $columns = ['*'])
    {
        try {
            return InfoProduct::where('product_key', $product_key)->select($columns)->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
