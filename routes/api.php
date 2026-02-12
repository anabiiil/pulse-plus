<?php

use App\Http\Controllers\Api\Website\ContactController;
use App\Http\Controllers\Api\Website\ProductController;
use App\Http\Controllers\Api\Website\ServiceController;
use App\Http\Controllers\Api\Website\SettingController;
use App\Http\Controllers\Api\Website\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Pulse API',
        'version' => '1.0',
        'status' => 'active'
    ]);
});

// Website Public API Routes
Route::prefix('website')->group(function () {

    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Sliders
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/sliders/{id}', [SliderController::class, 'show']);

    // Settings (accessible by both guests and authenticated users)
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/settings/all', [SettingController::class, 'getAll']);
    Route::get('/settings/slug/{slug}', [SettingController::class, 'getBySlug']);
    Route::get('/settings/{id}', [SettingController::class, 'show']);

    // Contact Form
    Route::post('/contact', [ContactController::class, 'store']);
});


