<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// API RESTful TriverseStore (Sprint 08): satu resource controller
// yang sama dengan web, sesuai pola PPT — Route::apiResource
// di routes/api.php memakai ProductController yang sama.
// Bedanya dengan rute web: respons selalu JSON, tanpa auth.
Route::apiResource('products', ProductController::class);
