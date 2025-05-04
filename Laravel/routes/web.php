<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairPartController;

// Customer routes
Route::get('customers/', [CustomerController::class, 'index'])->name('customers.index');
Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

// Car routes
Route::get('cars/', [CarController::class, 'index'])->name('cars.index');
Route::get('cars/create', [CarController::class, 'create'])->name('cars.create');
Route::post('cars', [CarController::class, 'store'])->name('cars.store');
Route::get('cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('cars/{car}', [CarController::class, 'update'])->name('cars.update');
Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

// Spare Part routes
Route::get('spare-parts/', [SparePartController::class, 'index'])->name('spare-parts.index');
Route::get('spare-parts/create', [SparePartController::class, 'create'])->name('spare-parts.create');
Route::post('spare-parts', [SparePartController::class, 'store'])->name('spare-parts.store');
Route::get('spare-parts/{sparePart}/edit', [SparePartController::class, 'edit'])->name('spare-parts.edit');
Route::put('spare-parts/{sparePart}', [SparePartController::class, 'update'])->name('spare-parts.update');
Route::delete('spare-parts/{sparePart}', [SparePartController::class, 'destroy'])->name('spare-parts.destroy');

// Repair routes
Route::get('repairs/', [RepairController::class, 'index'])->name('repairs.index');
Route::get('repairs/create', [RepairController::class, 'create'])->name('repairs.create');
Route::post('repairs', [RepairController::class, 'store'])->name('repairs.store');
Route::get('repairs/{repair}/edit', [RepairController::class, 'edit'])->name('repairs.edit');
Route::put('repairs/{repair}', [RepairController::class, 'update'])->name('repairs.update');
Route::delete('repairs/{repair}', [RepairController::class, 'destroy'])->name('repairs.destroy');

// Repair Part routes
Route::get('repair-parts/', [RepairPartController::class, 'index'])->name('repair-parts.index');
Route::get('repair-parts/create', [RepairPartController::class, 'create'])->name('repair-parts.create');
Route::post('repair-parts', [RepairPartController::class, 'store'])->name('repair-parts.store');
Route::get('repair-parts/{repairPart}/edit', [RepairPartController::class, 'edit'])->name('repair-parts.edit');
Route::put('repair-parts/{repairPart}', [RepairPartController::class, 'update'])->name('repair-parts.update');
Route::delete('repair-parts/{repairPart}', [RepairPartController::class, 'destroy'])->name('repair-parts.destroy');

Route::get('/', function () {
    return view('welcome');
});

