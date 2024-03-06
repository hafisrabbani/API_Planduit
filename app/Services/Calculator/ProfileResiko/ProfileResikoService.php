<?php

namespace App\Services\Calculator\ProfileResiko;

use App\DTO\ProfileResikoDTO;
use LaravelEasyRepository\BaseService;

interface ProfileResikoService extends BaseService{
    public function setData(ProfileResikoDTO $data) : self;
    public function getResults() : array;
}
