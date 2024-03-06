<?php

namespace App\Services\Calculator\Zakat\ZakatPenghasilan;

use App\DTO\ZakatPenghasilanDTO;
use LaravelEasyRepository\BaseService;

interface ZakatPenghasilanService extends BaseService{
    public function setData(ZakatPenghasilanDTO $zakatPenghasilanDTO) : self;
    public function getResults() : array;
}
