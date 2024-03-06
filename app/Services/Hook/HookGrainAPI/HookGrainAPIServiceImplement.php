<?php

namespace App\Services\Hook\HookGrainAPI;

use GuzzleHttp\Client;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Cache;
class HookGrainAPIServiceImplement extends Service implements HookGrainAPIService{
    private $grainAPI = "https://panelharga.badanpangan.go.id/data/harga-provinsi/";
    public function getGrainPrice(): int
    {
        try {
            $cacheKey = 'grain_price';
            $cacheTime = now()->addHours(6);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
            $client = new Client();
            $this->setTimeApi();
            $response = $client->get($this->grainAPI);
            $response = json_decode($response->getBody(), true);
            Cache::put($cacheKey, $response['hargaratarata'], $cacheTime);
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
