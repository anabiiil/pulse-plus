<?php

use App\Http\Controllers\Dash\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('dash-login', [LoginController::class, 'login']);

Route::group(
    ['prefix' => 'dash', 'middleware' => 'checkAdmin'], function () {
    Route::get('/{any?}', static function () {
        return view('dash.pages.index');
    })->where('any', '.*');
});

// Website routes - catch all routes that are not /dash
Route::get('/{any?}', static function () {
    return view('website.index');
})->where('any', '^(?!dash).*$');

