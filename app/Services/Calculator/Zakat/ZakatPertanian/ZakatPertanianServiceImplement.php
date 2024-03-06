<?php

namespace App\Services\Calculator\Zakat\ZakatPertanian;

use App\DTO\ZakatPertanianDTO;
use LaravelEasyRepository\Service;

class ZakatPertanianServiceImplement extends Service implements ZakatPertanianService{
    private ZakatPertanianDTO $zakatPertanianDTO;
    private $results = [];
    const nishab = 653;
    private $nishabPrice = 0;
    public function setData(ZakatPertanianDTO $data): ZakatPertanianService
    {
        $this->nishabPrice = $data->grainPrice * self::nishab;
        $this->zakatPertanianDTO = $data;
        return $this;
    }

    private function calculateZakatPertanian(): ZakatPertanianService
    {
        $harvestPrice = $this->zakatPertanianDTO->totalHarvest;
        $zakatPercentage = ($this->zakatPertanianDTO->isWatered) ? 0.05 : 0.1;
        if($harvestPrice >= $this->nishabPrice) {
            $this->results['status'] = true;
            $this->results['zakat'] = $harvestPrice * $zakatPercentage;
        }else {
            $this->results['status'] = false;
            $this->results['zakat'] = 0;
        }
        return $this;
    }


    public function getResults(): array
    {
        $this->calculateZakatPertanian();
        return $this->results;
    }
}
