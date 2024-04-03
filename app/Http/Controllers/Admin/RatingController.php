<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Rating\RatingService;
class RatingController extends Controller
{
    private RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function index()
    {
        $data = $this->ratingService->getAllRating();
        $statistik = $this->ratingService->getStatistikRating();
        return view('Admin.Pages.Rating.index', compact('data', 'statistik'));
    }
}
