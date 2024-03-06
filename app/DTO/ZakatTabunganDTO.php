<?php

namespace App\DTO;

class ZakatTabunganDTO
{
    public $savings;
    public bool $bank;
    public float $interest;
    public $goldPrice;

    public function __construct($savings, $interest, $goldPrice, $bank = false)
    {
        $this->savings = $savings;
        $this->bank = $bank;
        $this->interest = $interest;
        $this->goldPrice = $goldPrice;
    }
}
