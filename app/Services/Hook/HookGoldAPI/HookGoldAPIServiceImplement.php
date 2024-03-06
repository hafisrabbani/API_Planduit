<?php

namespace App\Services\Hook\HookGoldAPI;

use GuzzleHttp\Client;
use LaravelEasyRepository\Service;

class HookGoldAPIServiceImplement extends Service implements HookGoldAPIService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    const API_URL = 'https://logam-mulia-api.vercel.app/prices/hargaemas-org';

    public function getGoldPrice(): int
    {
        try {
            $client = new Client();
            $response = $client->get(self::API_URL);
            $response = json_decode($response->getBody(), true);
            return $response['data'][0]['buy'];
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
