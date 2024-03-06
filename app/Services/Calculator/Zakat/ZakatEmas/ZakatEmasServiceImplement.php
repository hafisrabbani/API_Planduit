<?php

namespace App\Services\Calculator\Zakat\ZakatEmas;

use App\DTO\ZakatEmasDTO;
use LaravelEasyRepository\Service;

class ZakatEmasServiceImplement extends Service implements ZakatEmasService{
    private ZakatEmasDTO $zakatEmasDTO;
    private $results = [];
    const nisaab = 85;
    const zakat = 0.025;
    public function setData(ZakatEmasDTO $data): ZakatEmasService
    {
        $this->zakatEmasDTO = $data;
        return $this;
    }

    private function calculateZakatEmas(): ZakatEmasService
    {
        $goldPrice = $this->zakatEmasDTO->goldPrice;
        $goldWeight = $this->zakatEmasDTO->weight;
        $totalGoldPrice = $goldPrice * $goldWeight;
        if($goldWeight >= self::nisaab) {
            $this->results['status'] = true;
            $this->results['zakat'] = $totalGoldPrice * self::zakat;
        }else {
            $this->results['status'] = false;
            $this->results['zakat'] = 0;
        }
        return $this;
    }

    public function getResults(): array
    {
        $this->calculateZakatEmas();
        return $this->results;
    }
}
