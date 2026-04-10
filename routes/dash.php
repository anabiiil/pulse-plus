<?php

use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Dash\AdminsController;
use App\Http\Controllers\Dash\Auth\LoginController;
use App\Http\Controllers\Dash\CountryController;
use App\Http\Controllers\Dash\ItemController;
use App\Http\Controllers\Dash\ProductController;
use App\Http\Controllers\Dash\ServiceController;
use App\Http\Controllers\Dash\SettingController;
use App\Http\Controllers\Dash\SliderController;
use App\Http\Controllers\Dash\SubscriptionController;
use App\Http\Controllers\Dash\UserController;
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

        Route::apiResource('countries', CountryController::class);
        Route::apiResource('services', ServiceController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('sliders', SliderController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('subscriptions', SubscriptionController::class);
        Route::apiResource('settings', SettingController::class);
        Route::get('settings/slug/{slug}', [SettingController::class, 'getBySlug']);

        // Contact Messages Management
        Route::prefix('api/admin/contact-messages')->group(function () {
            Route::get('/', [ContactMessageController::class, 'index']);
            Route::get('/statistics', [ContactMessageController::class, 'statistics']);
            Route::get('/{id}', [ContactMessageController::class, 'show']);
            Route::patch('/{id}/mark-as-read', [ContactMessageController::class, 'markAsRead']);
            Route::delete('/{id}', [ContactMessageController::class, 'destroy']);
        });

    });
