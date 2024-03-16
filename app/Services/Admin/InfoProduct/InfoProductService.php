<?php

namespace App\Services\Admin\InfoProduct;

use App\DTO\Admin\InfoProductDTO;
use LaravelEasyRepository\BaseService;

interface InfoProductService extends BaseService{
    public function createInfoProduct(InfoProductDTO $infoProductDTO);
    public function updateInfoProduct(InfoProductDTO $infoProductDTO, int $id);
    public function deleteInfoProduct(int $id);
    public function getInfoProduct(int $id, $columns = ['*']);
    public function getAllInfoProduct($columns = ['*'],$callback = null);
    public function getInfoProductByProductKey(string $product_key, $columns = ['*']);
}
