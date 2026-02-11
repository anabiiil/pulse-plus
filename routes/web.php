<?php

use App\Http\Controllers\Dash\Auth\LoginController;
use App\Http\Controllers\Website\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Dashboard login
Route::get('dash-login', [LoginController::class, 'login']);

// Dashboard routes (protected)
Route::group(
    ['prefix' => 'dash', 'middleware' => 'checkAdmin'], function () {
    Route::get('/{any?}', static function () {
        return view('dash.pages.index');
    })->where('any', '.*');
});

// User authentication routes
Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::post('/register', [AuthController::class, 'register'])->name('user.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

    // Protected routes
    Route::middleware('checkUser')->group(function () {
        Route::get('/profile', function () {
            return response()->json(['data' => auth('web')->user()]);
        });
        Route::put('/profile', function (\Illuminate\Http\Request $request) {
            $user = auth('web')->user();
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
            ]);
            $user->update($validated);
            return response()->json(['data' => $user]);
        });
        Route::post('/change-password', function (\Illuminate\Http\Request $request) {
            $user = auth('web')->user();
            $validated = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            if (!\Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'errors' => ['current_password' => ['Current password is incorrect']]
                ], 422);
            }

            $user->update(['password' => \Hash::make($validated['password'])]);
            return response()->json(['message' => 'Password updated successfully']);
        });
    });
});

// Website routes
Route::get('/{any?}', static function () {
    return view('website.index');
})->where('any', '^(?!dash|user|api).*$');
