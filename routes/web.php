<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Only unauthenticated users can access)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (Only logged-in users can access)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [DocumentRequestController::class, 'index'])->name('dashboard');
    Route::post('/document-requests', [DocumentRequestController::class, 'store'])->name('document-requests.store');
    Route::put('/document-requests/{documentRequest}', [DocumentRequestController::class, 'update'])->name('document-requests.update');
});