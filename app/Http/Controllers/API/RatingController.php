<?php

namespace App\Http\Controllers\API;

use App\DTO\RatingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Services\Rating\RatingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    private RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function store(RatingRequest $request)
    {
        try {
            $request->validated();
            $data = new RatingDTO(
                $request->rating,
                $request->comment == null ? '' : $request->comment
            );
            $this->ratingService->postRating($data);

            return response()->json([
                'message' => 'Rating successfully added',
            ], 201);
        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
