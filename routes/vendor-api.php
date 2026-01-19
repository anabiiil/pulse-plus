<?php

use App\Http\Controllers\Api\Vendor\Auth\LoginController;
use App\Http\Controllers\Api\Vendor\EmployeeController;
use App\Http\Controllers\Api\Vendor\MealController;
use App\Http\Controllers\Api\Vendor\NutritionPlanController;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Vendor API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for vendors.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group with vendor authentication.
|
*/

// Apply localization middleware to all vendor routes
Route::middleware([SetLocale::class])->group(function () {


    Route::get('add-vendor', function () {
        $vendor = \App\Models\Vendor::updateOrCreate([
            'email' => 'a.nabiil@hotmail.com'
        ],
            [
                'name' => 'Vendor 1',
                'email' => 'a.nabiil@hotmail.com',
                'password' => Hash::make('123456'),
                'phone' => '1234567890',
            ]
        );
        \App\Models\Agency::create([
            'business_name' => 'Vendor 1',
            'email' => 'a.nabiil@hotmail.com',
            'phone' => '1234567890',
        ]);

        $vendor->update(['agency_id' => $vendor->agency_id]);

    });


    // Public authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('login', LoginController::class);
    });

    // Protected routes (authentication required)
    Route::middleware(['auth:vendor-api'])->group(function () {

        Route::get('/profile', function (Request $request) {
            return $request->user();
        });

        // Nutrition Plans CRUD
        Route::apiResource('nutrition-plans', NutritionPlanController::class);

        // Nutrition Plan Meals Management
        Route::prefix('nutrition-plans/{id}')->group(function () {
            Route::post('/meals/sync', [NutritionPlanController::class, 'syncMeals']);
            Route::post('/meals/attach', [NutritionPlanController::class, 'attachMeal']);
            Route::delete('/meals/{mealId}', [NutritionPlanController::class, 'detachMeal']);
            Route::patch('/meals/{mealId}', [NutritionPlanController::class, 'updateMealPivot']);
        });

        // Meals CRUD
        Route::apiResource('meals', MealController::class);

        // Employees CRUD
        Route::apiResource('employees', EmployeeController::class);

        // Employee toggle active status
        Route::patch('employees/{id}/toggle-active', [EmployeeController::class, 'toggleActive']);

//        Route::prefix('nutrition-plans')->group(function () {
//            Route::get('/', [NutritionPlanController::class, 'index']);
//            Route::post('/', [NutritionPlanController::class, 'store']);
//            Route::get('/{id}', [NutritionPlanController::class, 'show']);
//            Route::post('/{id}', [NutritionPlanController::class, 'update']); // Using POST for image upload
//            Route::delete('/{id}', [NutritionPlanController::class, 'destroy']);
//            Route::patch('/{id}/toggle-active', [NutritionPlanController::class, 'toggleActive']);
//        });
    });

});

