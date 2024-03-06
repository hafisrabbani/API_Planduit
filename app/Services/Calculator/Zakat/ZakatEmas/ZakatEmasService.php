<?php

namespace App\Services\Calculator\Zakat\ZakatEmas;

use App\DTO\ZakatEmasDTO;
use LaravelEasyRepository\BaseService;

interface ZakatEmasService extends BaseService{
    public function setData(ZakatEmasDTO $data) : self;
    public function getResults() : array;
}
