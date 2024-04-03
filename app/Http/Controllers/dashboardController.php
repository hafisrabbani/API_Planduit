<?php

namespace App\Http\Controllers;

use App\Services\Rating\RatingService;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    private RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }


    public function index()
    {
        $dataRatings = $this->ratingService->getStatistikRating();
        $dataRatings = json_encode($dataRatings);
        return view('Admin.Pages.Dashboard.index', compact('dataRatings'));
    }
}
