<?php

namespace App\DTO;

class ZakatPerdaganganDTO{
    public $rotatedCapital;
    public $profit;
    public $currentRecievable;
    public $currentPayable;
    public $loss;


    public function __construct($rotatedCapital, $profit, $currentRecievable = 0, $currentPayable = 0, $loss = 0){
        $this->rotatedCapital = $rotatedCapital;
        $this->profit = $profit;
        $this->currentRecievable = $currentRecievable;
        $this->currentPayable = $currentPayable;
        $this->loss = $loss;
    }
}
