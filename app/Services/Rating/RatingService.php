<?php

namespace App\Services\Rating;

use App\DTO\RatingDTO;
use LaravelEasyRepository\BaseService;

interface RatingService extends BaseService{
    public function postRating(RatingDTO $data);
    public function getAllRating($sort = 'created_at', $order = 'desc');
    public function getStatistikRating();
}
