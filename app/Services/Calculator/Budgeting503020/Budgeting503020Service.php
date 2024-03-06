<?php

namespace App\Services\Calculator\Budgeting503020;

use LaravelEasyRepository\BaseService;
use App\DTO\Budgeting503020;
interface Budgeting503020Service extends BaseService{
    public function setData(Budgeting503020 $data) : self;
    public function getResults() : array;
}
