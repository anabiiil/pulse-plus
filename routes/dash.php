<?php

use App\Http\Controllers\Dash\AdminsController;
use App\Http\Controllers\Dash\Auth\LoginController;
use App\Http\Controllers\Dash\CountryController;
use App\Http\Controllers\Dash\SliderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:admin']], static function () {
    Route::get('admin/login', [LoginController::class, 'login'])->name('login');
    Route::post('admin/login', [LoginController::class, 'loginForm'])->name('loginForm');
});


Route::group(
    ['middleware' => 'auth:admin'], static function () {


    Route::group(['prefix' => 'admins'], static function () {
        Route::get('/list', [AdminsController::class, 'list']);
        Route::get('/list/{id}', [AdminsController::class, 'show']);
        Route::post('/create', [AdminsController::class, 'create']);
        Route::patch('/update/{id}', [AdminsController::class, 'update']);
        Route::delete('/delete/{id}', [AdminsController::class, 'destroy']);
    });

    Route::group(['prefix' => 'slider'], static function () {
        Route::get('/list', [SliderController::class, 'list']);
        Route::get('/list/{id}', [SliderController::class, 'show']);
        Route::post('/create', [SliderController::class, 'create']);
        Route::post('/update/{id}', [SliderController::class, 'update']);
        Route::delete('/delete/{id}', [SliderController::class, 'destroy']);
    });

    Route::group(['prefix' => 'countries'], static function () {
        Route::get('/list', [CountryController::class, 'list']);
        Route::get('/list/{id}', [CountryController::class, 'show']);
        Route::post('/create', [CountryController::class, 'create']);
        Route::patch('/update/{id}', [CountryController::class, 'update']);
        Route::delete('/delete/{id}', [CountryController::class, 'destroy']);
    });


});
