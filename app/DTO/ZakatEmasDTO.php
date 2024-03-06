<?php

namespace App\DTO;

class ZakatEmasDTO{
    public float $weight;
    public $goldPrice;
    public function __construct(float $weight, $price)
    {
        $this->weight = $weight;
        $this->goldPrice = $price;
    }
}
