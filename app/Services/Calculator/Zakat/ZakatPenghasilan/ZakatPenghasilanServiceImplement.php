<?php

namespace App\Services\Calculator\Zakat\ZakatPenghasilan;

use App\DTO\ZakatPenghasilanDTO;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use LaravelEasyRepository\Service;

class ZakatPenghasilanServiceImplement extends Service implements ZakatPenghasilanService{
    private ZakatPenghasilanDTO $zakatPenghasilanDTO;
    public $results = [];

    public function setData(ZakatPenghasilanDTO $data) : self
    {
        $this->zakatPenghasilanDTO = $data;
        return $this;
    }

    private function calculateZakatPenghasilan(): self
    {
        $income = $this->zakatPenghasilanDTO->income;
        $anotherIncome = $this->zakatPenghasilanDTO->anotherIncome;
        $expenditure = $this->zakatPenghasilanDTO->expenditure;
        $goldPrice = $this->zakatPenghasilanDTO->goldPrice;
        $timeType = $this->zakatPenghasilanDTO->timeType;
        $nisaab = 85 * $goldPrice;
        $totalIncome = 0;
        if($timeType === ZakatPenghasilanDTO::constantTimeType['MONTHLY']) {
            $totalIncome = ($income + $anotherIncome) * 12;
            $expenditure = $expenditure * 12;
        }
        $totalMoney = $totalIncome - $expenditure;
        if($totalMoney >= $nisaab) {
            $this->results['status'] = true;
            $this->results['zakat'] = $totalMoney * 0.025;
        }else {
            $this->results['status'] = false;
            $this->results['zakat'] = 0;
        }
        return $this;
    }

    public function getResults(): array
    {
        $this->calculateZakatPenghasilan();
        return $this->results;
    }
}
