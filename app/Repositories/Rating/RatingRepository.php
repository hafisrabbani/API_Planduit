<?php

namespace App\Repositories\Rating;

use LaravelEasyRepository\Repository;
use App\DTO\RatingDTO;
interface RatingRepository extends Repository{
    public function postRating(RatingDTO $data);
    public function getAllRating($sort = 'created_at', $order = 'desc');
    public function getStatistikRating();
}
