<?php

namespace App\Services\Hook\HookGrainAPI;

use GuzzleHttp\Client;
use LaravelEasyRepository\Service;

class HookGrainAPIServiceImplement extends Service implements HookGrainAPIService{
    private $grainAPI = "https://panelharga.badanpangan.go.id/data/harga-provinsi/";
    public function getGrainPrice(): int
    {
        try {
            $client = new Client();
            $this->setTimeApi();
            $response = $client->get($this->grainAPI);
            $response = json_decode($response->getBody(), true);
            return $response['hargaratarata'];
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function setTimeApi($time = null){
        if($time == null){
            $time = date('d-m-Y');
        }
        $this->grainAPI = $this->grainAPI.$time."/3/27";
    }
}
