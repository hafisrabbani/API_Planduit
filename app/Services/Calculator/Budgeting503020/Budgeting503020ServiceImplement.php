<?php

namespace App\Services\Calculator\Budgeting503020;

use LaravelEasyRepository\Service;
use App\DTO\Budgeting503020;
class Budgeting503020ServiceImplement extends Service implements Budgeting503020Service{
    private Budgeting503020 $data;
    private array $results;
    public function setData(Budgeting503020 $data) : self
    {
        $this->data = $data;
        return $this;
    }


    private function calculation(){
        $this->results['income'] = $this->data->income;
        $this->results['needs'] = $this->data->income * 0.5;
        $this->results['wants'] = $this->data->income * 0.3;
        $this->results['savings'] = $this->data->income * 0.2;
    }

    public function getResults() : array
    {
        $this->calculation();
        return $this->results;
    }
}
