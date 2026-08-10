<?php

use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\Website\AuthController;
use App\Http\Controllers\Api\Website\CartController;
use App\Http\Controllers\Api\Website\CheckoutController;
use App\Http\Controllers\Api\Website\ContactController;
use App\Http\Controllers\Api\Website\EnumController;
use App\Http\Controllers\Api\Website\GovernorateController;
use App\Http\Controllers\Api\Website\HomeController;
use App\Http\Controllers\Api\Website\MedicalFileController;
use App\Http\Controllers\Api\Website\MedicalInfoController;
use App\Http\Controllers\Api\Website\NationalityController;
use App\Http\Controllers\Api\Website\OrderController;
use App\Http\Controllers\Api\Website\PaymentMethodController;
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
        'status' => 'active',
    ]);
});

// Website Public API Routes
Route::prefix('website')->group(function () {

    // Home Page Data (Sliders, Products, Services)
    Route::get('/home', [HomeController::class, 'index']);

    // Authentication (Guest)
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Authentication (Protected)
    Route::middleware('auth:web')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
        Route::post('/auth/profile', [AuthController::class, 'updateProfile']); // POST for FormData
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

        // Medical Info (blood type, emergency number, notes, diseases sync)
        Route::put('/medical-info', [MedicalInfoController::class, 'updateMedicalInfo']);

        // Medical Files (archive)
        Route::get('/medical-files', [MedicalFileController::class, 'index']);
        Route::post('/medical-files', [MedicalFileController::class, 'store']);
        Route::post('/medical-files/{medicalFile}', [MedicalFileController::class, 'update']);
        Route::delete('/medical-files/{medicalFile}', [MedicalFileController::class, 'destroy']);

        // Orders (user's own — requires an account)
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
    });

    // Cart & checkout (available to guests — session based, no account needed)
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::patch('/cart/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);
    Route::post('/checkout', [CheckoutController::class, 'store']);

    // Chronic Diseases (public list by language)
    Route::get('/diseases', [MedicalInfoController::class, 'diseases']);

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

    // Nationalities (Countries)
    Route::get('/nationalities', [NationalityController::class, 'index']);

    // Governorates (active, with delivery price — for checkout)
    Route::get('/governorates', [GovernorateController::class, 'index']);

    // Payment methods (active — for checkout)
    Route::get('/payment-methods', [PaymentMethodController::class, 'index']);

    // Enums
    Route::get('/enums/marital-status', [EnumController::class, 'maritalStatus']);
    Route::get('/medical-files/categories', [MedicalFileController::class, 'categories']);

    // Contact Form (Public - No Auth Required)
    Route::post('/contact-messages', [ContactMessageController::class, 'store']);
    Route::get('/contact-info', [ContactMessageController::class, 'getContactInfo']);

    // User Info by UUID (Public - No Auth Required)
    Route::get('/user/info/{uuid}', [\App\Http\Controllers\Api\Website\UserInfoController::class, 'show']);

    // Contact Form (Old endpoint for backward compatibility)
    Route::post('/contact', [ContactController::class, 'store']);
});

// Admin Contact Messages Management
Route::prefix('admin/contact-messages')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ContactMessageController::class, 'index']);
    Route::get('/statistics', [ContactMessageController::class, 'statistics']);
    Route::get('/{id}', [ContactMessageController::class, 'show']);
    Route::patch('/{id}/mark-as-read', [ContactMessageController::class, 'markAsRead']);
    Route::delete('/{id}', [ContactMessageController::class, 'destroy']);
});
