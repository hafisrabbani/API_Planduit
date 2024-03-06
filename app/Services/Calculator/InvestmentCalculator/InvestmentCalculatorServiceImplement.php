<?php

namespace App\Services\Calculator\InvestmentCalculator;

use App\DTO\InvestmentDTO;
use LaravelEasyRepository\Service;

class InvestmentCalculatorServiceImplement extends Service implements InvestmentCalculatorService
{

    protected InvestmentDTO $investmentDTO;
    const MONTHPERYEAR = 12;


    public function getResults()
    {
        return $this->calculateResult();
    }

    private function findTimeInvestment($timeType, $targetTime)
    {
        return $timeType === 'YEARLY' ? $targetTime : $targetTime * self::MONTHPERYEAR;
    }

    private function findReturnInvestmentPerPeriod($timeType, $returnInvestment)
    {
        return $timeType === 'YEARLY' ? $returnInvestment : number_format($returnInvestment / self::MONTHPERYEAR,16);
    }

    private function findReturnPerPeriod($returnPerPeriod, $moneyInvestment)
    {
        return $moneyInvestment * ($returnPerPeriod / 100);
    }

    private function doCalculation()
    {
        $iteration = $this->findTimeInvestment(
            $this->investmentDTO->timeType,
            $this->investmentDTO->targetTime);
        $returnInvestment = $this->findReturnInvestmentPerPeriod(
            $this->investmentDTO->timeType,
            $this->investmentDTO->interest);
        $result = floor($this->calculateInvestment(
            $iteration,
            $returnInvestment,
            $this->investmentDTO->moneyInvestment,
            $this->investmentDTO->initialMoney)
        );

        $isSuccess = $result >= $this->investmentDTO->targetMoney;
        $recommendation = ($isSuccess) ? null : $this->findRecommendation(
            $this->investmentDTO->targetMoney,
            $this->investmentDTO->initialMoney,
            $this->investmentDTO->moneyInvestment,
            $this->investmentDTO->timeType,
            $this->investmentDTO->interest
        );
        $majorInvestment = $this->investmentDTO->initialMoney + ($this->investmentDTO->moneyInvestment * $iteration);
        $investInterest = $result - $majorInvestment;

        return [
            'is_success' => $isSuccess,
            'result' => $result,
            'major_investment' => $majorInvestment,
            'invest_interest' => $investInterest,
            'recommendation' => $recommendation
        ];

    }

    private function calculateInvestment($iteration, $returnInvestment, $moneyInvestPerPeriod, $initialMoney)
    {
        if ($iteration === 0) return $initialMoney;
        $temp = 0;
        for ($i = 0; $i < $iteration; $i++) {
            if ($i === 0) {
                $temp = $initialMoney + $moneyInvestPerPeriod + $this->findReturnPerPeriod($returnInvestment, $initialMoney+$moneyInvestPerPeriod);
            } else {
                $temp = $temp + $moneyInvestPerPeriod + $this->findReturnPerPeriod($returnInvestment, $temp + $moneyInvestPerPeriod);
            }
        }
        return $temp;
    }

    private function findRecommendation($targetMoney, $initialMoney, $moneyInvestment, $timeType, $interest)
    {
        $year = 0;
        $temp = 0;
        $totalMoney = 0;
        $majorInvestment = 0;
        $returnInvestment = 0;
        $isSuccess = false;

        while(!$isSuccess) {
            $year++;
            $temp = floor($this->calculateInvestment(
                $this->findTimeInvestment($timeType, $year),
                $this->findReturnInvestmentPerPeriod($timeType, $interest),
                $moneyInvestment,
                $initialMoney
            ));
            $isSuccess = $temp >= $targetMoney;
            $totalMoney = $temp;
            $majorInvestment = $initialMoney + ($moneyInvestment * $this->findTimeInvestment($timeType, $year));
            $returnInvestment = $totalMoney - $majorInvestment;
        }

        return [
            'year' => $year,
            'result' => $totalMoney,
            'invest_primary' => $majorInvestment,
            'invest_primary_percentage' => round(($majorInvestment / $totalMoney) * 100, 2),
            'invest_interest' => $returnInvestment,
            'invest_interest_percentage' => round(($returnInvestment / $totalMoney) * 100, 2),
        ];

    }

    private function calculateResult()
    {
        try {
            $data = $this->doCalculation();
            return [
                'is_success' => $data['is_success'],
                'result' => $data['result'],
                'invest_primary' => $data['major_investment'],
                'invest_primary_percentage' => round(($data['major_investment'] / $data['result']) * 100, 2),
                'invest_interest' => $data['invest_interest'],
                'invest_interest_percentage' => round(($data['invest_interest'] / $data['result']) * 100, 2),
                'recommendation' => $data['recommendation']
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function setData(InvestmentDTO $investmentDTO)
    {
        $this->investmentDTO = $investmentDTO;
        return $this;
    }
}
