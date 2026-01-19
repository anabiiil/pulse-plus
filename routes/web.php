<?php

use App\Http\Controllers\Dash\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    if (auth('admin')->check()) {
        return redirect('/admin');
    }
    return view('pages.admin.auth.login');
});

Route::get('dash-login', [LoginController::class, 'login']);

Route::group(
    ['prefix' => 'dash', 'middleware' => 'checkAdmin'], function () {
    Route::get('/{any?}', static function () {
        return view('dash.pages.index');
    })->where('any', '.*');
});
