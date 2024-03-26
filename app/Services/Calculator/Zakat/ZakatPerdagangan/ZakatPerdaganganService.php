<?php

namespace App\Services\Calculator\Zakat\ZakatPerdagangan;

use App\DTO\ZakatPerdaganganDTO;
use LaravelEasyRepository\BaseService;

interface ZakatPerdaganganService extends BaseService{
    public function setData(ZakatPerdaganganDTO $data, $goldPrice) : self;
    public function getResults() : array;
}
