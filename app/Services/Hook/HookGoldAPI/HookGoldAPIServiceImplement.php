<?php

namespace App\Services\Hook\HookGoldAPI;

use GuzzleHttp\Client;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Cache;
class HookGoldAPIServiceImplement extends Service implements HookGoldAPIService
{
    const API_URL = 'https://logam-mulia-api.vercel.app/prices/hargaemas-org';

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
            Cache::put($cacheKey, $response['data'][0]['buy'], $cacheTime);
            return $response['data'][0]['buy'];
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
