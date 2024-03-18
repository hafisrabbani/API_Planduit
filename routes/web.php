<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InfoProductController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Test\TestingController;
Route::get('/', function () {
    return 'Nothing to see here :)';
});

Route::get('/admin/v1/panel/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/v1/panel/login', [AuthController::class, 'loginPost'])->name('admin.login.post');

Route::group(['prefix' => 'admin/panel/v1/planduit', 'as' => 'admin.v1.', 'middleware' => 'auth'], function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('info-product', InfoProductController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('blog-category', BlogCategoryController::class);
    Route::post('ckeditor-upload', [BlogController::class, 'ckeditorUpload'])->name('ckeditor.upload');
});

Route::prefix('test')->group(function () {
    Route::get('test', [TestingController::class, 'templateTest'])->name('test.template');
});
