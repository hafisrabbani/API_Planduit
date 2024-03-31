<?php

namespace App\Services\Hook\HookGoldAPI;

use GuzzleHttp\Client;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Cache;
class HookGoldAPIServiceImplement extends Service implements HookGoldAPIService
{
    const API_URL = 'https://www.indogold.id/ajax/chart_interval/GOLD/1';
    public function getGoldPrice(): int
    {
        try {
            $cacheKey = 'gold_price';
            $cacheTime = now()->addHours(6);
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
            $client = new Client();
            $response = $client->get(self::API_URL);
            $response = json_decode($response->getBody(), true);
            $results = $response[0]['data'][0][1];
            Cache::put($cacheKey, $results, $cacheTime);
            return $results;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
