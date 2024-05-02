<?php

use App\Http\Controllers\Info\InformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test\TestingController;
use App\Http\Controllers\Calculator\FinancialCalculatorController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\DictionaryController;

Route::group(['prefix' => 'test'], function () {
    Route::get('gold-price', [TestingController::class, 'index']);
    Route::get('calculate-investment', [TestingController::class, 'calculateInvestment']);
});

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'calculator'], function () {
        Route::post('investment', [FinancialCalculatorController::class, 'storeInvestment']);
        Route::post('budgeting-503020', [FinancialCalculatorController::class, 'storeBudgeting503020']);
        Route::get('profile-resiko', [FinancialCalculatorController::class, 'getQuestionProfileResiko']);
        Route::post('profile-resiko', [FinancialCalculatorController::class, 'storeProfileResiko']);
        Route::post('zakat-penghasilan', [FinancialCalculatorController::class, 'storeZakatPenghasilan']);
        Route::post('zakat-emas', [FinancialCalculatorController::class, 'storeZakatEmas']);
        Route::post('zakat-tabungan', [FinancialCalculatorController::class, 'storeZakatTabungan']);
        Route::post('zakat-pertanian', [FinancialCalculatorController::class, 'storeZakatPertanian']);
        Route::post('zakat-perdagangan', [FinancialCalculatorController::class, 'storeZakatPerdagangan']);
    });

    Route::group(['prefix' => 'info'], function () {
        Route::get('gold-price', [InformationController::class, 'infoGoldPrice']);
        Route::get('grain-price', [InformationController::class, 'infoGrainPrice']);
        Route::get('product', [InformationController::class, 'getAllProduct']);
        Route::get('product/{key}', [InformationController::class, 'infoProductDetail']);
    });

    Route::group(['prefix' => 'blog'], function () {
        Route::get('all', [BlogController::class, 'getAll']);
        Route::get('detail/{id}', [BlogController::class, 'getDetail']);
        Route::get('category', [BlogController::class, 'getAllCategory']);
    });

    Route::group(['prefix' => 'dictionary'],function (){
        Route::get('/', [DictionaryController::class, 'index']);
        Route::get('/{id}', [DictionaryController::class, 'detail']);
    });

    Route::group(['prefix' => 'common'], function () {
        Route::post('rating', [RatingController::class, 'store']);
    });
});
