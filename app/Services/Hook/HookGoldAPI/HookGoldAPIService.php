<?php

namespace App\Services\Hook\HookGoldAPI;

use LaravelEasyRepository\BaseService;

interface HookGoldAPIService extends BaseService{
    public function getGoldPrice(): int;
}
