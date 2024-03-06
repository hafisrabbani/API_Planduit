<?php

namespace App\Services\Calculator\Zakat\ZakatTabungan;

use App\DTO\ZakatTabunganDTO;
use LaravelEasyRepository\Service;

class ZakatTabunganServiceImplement extends Service implements ZakatTabunganService{
    private ZakatTabunganDTO $zakatTabunganDTO;
    private $nisaab;
    public function setData(ZakatTabunganDTO $data): ZakatTabunganService
    {
        $this->zakatTabunganDTO = $data;
        $this->nisaab = 85 * $data->goldPrice;
        return $this;
    }

    private function calculateZakatTabungan()
    {
        $savings = $this->zakatTabunganDTO->savings;
        $bank = (bool)$this->zakatTabunganDTO->bank;
        $interest = $this->zakatTabunganDTO->interest;
        if($bank){
            $ammountInterest = $savings * ($interest / 100);
            $savings = $savings - $ammountInterest;
        }
        if($savings >= $this->nisaab) {
            $this->results['status'] = true;
            $this->results['zakat'] = $savings * 0.025;
        }else {
            $this->results['status'] = false;
            $this->results['zakat'] = 0;
        }
    }

    public function getResults(): array
    {
        $this->calculateZakatTabungan();
        return $this->results;
    }
}
