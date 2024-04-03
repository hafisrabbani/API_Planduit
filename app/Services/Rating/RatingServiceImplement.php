<?php

namespace App\Services\Rating;

use App\DTO\RatingDTO;
use LaravelEasyRepository\Service;
use App\Repositories\Rating\RatingRepository;

class RatingServiceImplement extends Service implements RatingService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(RatingRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function postRating(RatingDTO $data)
    {
        try {
            return $this->mainRepository->postRating($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllRating($sort = 'created_at', $order = 'desc')
    {
        try {
            return $this->mainRepository->getAllRating($sort, $order);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getStatistikRating()
    {
        try {
            return $this->mainRepository->getStatistikRating();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
