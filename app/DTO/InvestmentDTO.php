<?php

namespace App\DTO;

class InvestmentDTO
{
    public $targetMoney;
    public $targetTime;
    public $initialMoney;
    public $moneyInvestment;
    public $timeType;
    public $interest;
    const constantTimeType = [
        'YEARLY' => 'YEARLY',
        'MONTHLY' => 'MONTHLY',
    ];
    public function __construct($targetMoney, $targetTime, $initialMoney, $moneyInvestment, $timeType, $interest)
    {
        $this->targetMoney = $targetMoney;
        $this->targetTime = $targetTime;
        $this->initialMoney = $initialMoney;
        $this->moneyInvestment = $moneyInvestment;
        if (!in_array($timeType, [self::constantTimeType['MONTHLY'], self::constantTimeType['YEARLY']])) {
            throw new \Exception('Invalid time type');
        }
        $this->timeType = $timeType;
        $this->interest = $interest;
    }
}
