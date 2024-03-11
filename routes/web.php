<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InfoProductController;
use App\Http\Controllers\Test\TestingController;
Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin/panel/v1/planduit', 'as' => 'admin.v1.'], function () {
    Route::resource('info-product', InfoProductController::class);
});

Route::prefix('test')->group(function () {
    Route::get('test', [TestingController::class, 'templateTest'])->name('test.template');
});
