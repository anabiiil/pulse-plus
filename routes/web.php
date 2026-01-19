<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    return view('welcome');
});

// Image Upload Test Routes
// File Upload Test Routes
Route::get('/file-upload', [FileUploadController::class, 'showForm'])->name('file.form');
Route::post('/file-upload', [FileUploadController::class, 'upload'])->name('file.upload');

