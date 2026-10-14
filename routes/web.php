<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// páginas que cargan Vue
Route::get('/', function () {
    return view('app');
});

Route::get('/login', function () {
    return view('app');
})->name('login');

// rutas del login (públicas)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/me', [AuthController::class, 'me']);

// rutas protegidas: solo entra quien tenga sesión
Route::middleware('auth')->group(function () {
    Route::get('/api/products', [ProductController::class, 'index']);

    Route::middleware('admin')->group(function () {
        Route::post('/api/products', [ProductController::class, 'store']);
        Route::put('/api/products/{product}', [ProductController::class, 'update']);
        Route::delete('/api/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/api/comisiones/iniciales', [ComisionController::class, 'index']);
        Route::post('/api/comisiones/calcular', [ComisionController::class, 'calcular']);
    });
});
