<?php

namespace App\Services\Hook\HookGrainAPI;

use LaravelEasyRepository\BaseService;

interface HookGrainAPIService extends BaseService{
    public function getGrainPrice(): int;
}
