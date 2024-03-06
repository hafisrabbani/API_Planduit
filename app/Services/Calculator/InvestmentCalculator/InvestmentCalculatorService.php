<?php

namespace App\Services\Calculator\InvestmentCalculator;

use LaravelEasyRepository\BaseService;
use App\DTO\InvestmentDTO;
interface InvestmentCalculatorService extends BaseService{
    public function getResults();
    public function setData(InvestmentDTO $investmentDTO);
}
