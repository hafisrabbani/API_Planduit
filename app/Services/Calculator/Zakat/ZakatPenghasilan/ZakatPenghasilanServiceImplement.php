<?php

namespace App\Services\Calculator\Zakat\ZakatPenghasilan;

use App\DTO\ZakatPenghasilanDTO;
use App\Services\Hook\HookGoldAPI\HookGoldAPIService;
use LaravelEasyRepository\Service;

/**
 *
 */
class ZakatPenghasilanServiceImplement extends Service implements ZakatPenghasilanService{
    /**
     * @var ZakatPenghasilanDTO
     */
    private ZakatPenghasilanDTO $zakatPenghasilanDTO;
    /**
     * @var array
     */
    public $results = [];

    /**
     * @param ZakatPenghasilanDTO $zakatPenghasilanDTO
     * @return $this
     */
    public function setData(ZakatPenghasilanDTO $zakatPenghasilanDTO) : self
    {
        $this->zakatPenghasilanDTO = $zakatPenghasilanDTO;
        return $this;
    }

    /**
     * @return self
     */
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

    /**
     * @return array
     */
    public function getResults(): array
    {
        $this->calculateZakatPenghasilan();
        return $this->results;
    }
}
