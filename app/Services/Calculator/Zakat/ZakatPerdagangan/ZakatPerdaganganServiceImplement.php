<?php

namespace App\Services\Calculator\Zakat\ZakatPerdagangan;

use App\DTO\ZakatPerdaganganDTO;
use LaravelEasyRepository\Service;

class ZakatPerdaganganServiceImplement extends Service implements ZakatPerdaganganService{
    private ZakatPerdaganganDTO $zakatPerdaganganDTO;
    private $results = [];
    private $goldPrice = 0;
    public function setData(ZakatPerdaganganDTO $data, $goldPrice): ZakatPerdaganganService
    {
        $this->zakatPerdaganganDTO = $data;
        $this->goldPrice = $goldPrice;
        return $this;
    }

    public function calculateResults(){
        $total = (
            $this->zakatPerdaganganDTO->rotatedCapital +
            $this->zakatPerdaganganDTO->currentRecievable +
            $this->zakatPerdaganganDTO->profit
        ) - (
            $this->zakatPerdaganganDTO->currentPayable +
            $this->zakatPerdaganganDTO->loss
        );
        $nisaab = 85 * $this->goldPrice;
        if($total >= $nisaab) {
            $this->results['status'] = true;
            $this->results['zakat'] = $total * 0.025;
        }else {
            $this->results['status'] = false;
            $this->results['zakat'] = 0;
        }
    }

    public function getResults(): array
    {
        $this->calculateResults();
        return $this->results;
    }
}
