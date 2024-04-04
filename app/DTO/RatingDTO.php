<?php

namespace App\DTO;

class RatingDTO{
    public int $rating;
    public string $comment;

    public function __construct(int $rating,$comment){
        $this->rating = $rating;
        $this->comment = $comment;
    }
}
