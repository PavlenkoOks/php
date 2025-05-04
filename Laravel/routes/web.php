<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairPartController;

// Resource routes
Route::resource('customers', CustomerController::class)->middleware('role:Admin,customers.index');
Route::resource('cars', CarController::class)->middleware('role:Admin,Manager,cars.index');
Route::resource('spare-parts', SparePartController::class)->middleware('role:Admin,Manager,spare-parts.index');
Route::resource('repairs', RepairController::class)->middleware('role:Admin,Manager,repairs.index');
Route::resource('repair-parts', RepairPartController::class)->middleware('role:Admin,Manager,repair-parts.index');

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'store'])->name('register.store');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.authenticate');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');