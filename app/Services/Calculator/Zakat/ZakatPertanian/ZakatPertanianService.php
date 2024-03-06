<?php

namespace App\Services\Calculator\Zakat\ZakatPertanian;

use App\DTO\ZakatPertanianDTO;
use LaravelEasyRepository\BaseService;

interface ZakatPertanianService extends BaseService{
    public function setData(ZakatPertanianDTO $data) : self;
    public function getResults() : array;
}
