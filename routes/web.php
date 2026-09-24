<?php

use App\Http\Controllers\DocumentRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DocumentRequestController::class, 'index']);
Route::post('/document-requests', [DocumentRequestController::class, 'store']);
