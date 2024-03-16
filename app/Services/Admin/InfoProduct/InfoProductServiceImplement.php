<?php

namespace App\Services\Admin\InfoProduct;

use App\DTO\Admin\InfoProductDTO;
use LaravelEasyRepository\Service;
use App\Repositories\InfoProduct\InfoProductRepository;

class InfoProductServiceImplement extends Service implements InfoProductService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(InfoProductRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function createInfoProduct(InfoProductDTO $infoProductDTO)
    {
        return $this->mainRepository->creatInfoProduct($infoProductDTO);
    }

    public function updateInfoProduct(InfoProductDTO $infoProductDTO, int $id)
    {
        return $this->mainRepository->updateInfoProduct($infoProductDTO, $id);
    }

    public function deleteInfoProduct(int $id)
    {
        return $this->mainRepository->deleteInfoProduct($id);
    }

    public function getInfoProduct(int $id, $columns = ['*'])
    {
        return $this->mainRepository->getInfoProduct($id, $columns);
    }

    public function getAllInfoProduct($columns = ['*'], $callback = null)
    {
        return $this->mainRepository->getAllInfoProduct($columns, $callback);
    }

    public function getInfoProductByProductKey(string $product_key, $columns = ['*'])
    {
        return $this->mainRepository->getInfoProductByProductKey($product_key, $columns);
    }
}
