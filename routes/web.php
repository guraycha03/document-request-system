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
// GET = read, POST = create, PATCH = change status
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DocumentRequestController::class, 'index'])->name('dashboard');
    Route::get('/document-requests/{documentRequest}', [DocumentRequestController::class, 'show'])->name('document-requests.show');
    Route::post('/document-requests', [DocumentRequestController::class, 'store'])->name('document-requests.store');
    Route::patch('/document-requests/{documentRequest}', [DocumentRequestController::class, 'updateStatus'])->name('document-requests.update-status');
});
