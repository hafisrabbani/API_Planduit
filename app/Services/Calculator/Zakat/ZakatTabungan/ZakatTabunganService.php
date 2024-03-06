<?php

namespace App\Services\Calculator\Zakat\ZakatTabungan;

use LaravelEasyRepository\BaseService;
use App\DTO\ZakatTabunganDTO;
interface ZakatTabunganService extends BaseService{
    public function setData(ZakatTabunganDTO $data) : self;
    public function getResults() : array;
}
