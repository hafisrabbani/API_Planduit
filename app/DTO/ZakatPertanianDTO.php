<?php

namespace App\DTO;

class ZakatPertanianDTO{
    public $totalHarvest;
    public $isWatered;
    public $grainPrice;

    public function __construct($totalHarvest, $isWatered,$grainPrice){
        $this->totalHarvest = $totalHarvest;
        $this->isWatered = $isWatered;
        $this->grainPrice = $grainPrice;
    }
}
