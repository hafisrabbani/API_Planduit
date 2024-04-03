<?php

namespace App\Repositories\Rating;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Rating;
use App\DTO\RatingDTO;
class RatingRepositoryImplement extends Eloquent implements RatingRepository{

    protected $model;

    public function __construct(Rating $model)
    {
        $this->model = $model;
    }

    public function postRating(RatingDTO $data)
    {
        try {
            $model = new Rating();
            $model->rating = $data->rating;
            $model->comment = $data->comment;
            $model->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllRating($sort = 'created_at', $order = 'desc')
    {
        try {
            return $this->model->orderBy($sort, $order)->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getStatistikRating()
    {
        try {
            return $this->model->selectRaw('rating, count(rating) as total')->groupBy('rating')->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
