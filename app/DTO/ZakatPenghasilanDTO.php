<?php

namespace App\DTO;


class ZakatPenghasilanDTO
{
    public $income;
    public $anotherIncome;
    public $expenditure;
    public $timeType;

    public $goldPrice;
    const constantTimeType = [
        'YEARLY' => 'YEARLY',
        'MONTHLY' => 'MONTHLY',
    ];
    public function __construct($income, $anotherIncome, $expenditure, $timeType, $goldPrice)
    {
        $this->income = $income;
        $this->anotherIncome = $anotherIncome;
        $this->expenditure = $expenditure;
        if (!in_array($timeType, [self::constantTimeType['MONTHLY'], self::constantTimeType['YEARLY']])) {
            throw new \Exception('Invalid time type');
        }
        $this->timeType = $timeType;
        $this->goldPrice = $goldPrice;
    }
}
