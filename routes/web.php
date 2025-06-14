<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::get('/index', [DashboardController::class, 'index'])->name('index.dashboard');
  Route::get('/salary', [DashboardController::class, 'salaries'])->name('salaries.index');

  Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
  Route::get('/invoice', [InvoiceController::class, 'datatable'])->name('invoices.datatable');
  // Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
  // Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoices.store');

  // Route::prefix('invoices')->name('invoice.')->group(function () {
  //   Route::get('/create', [InvoiceController::class, 'create'])->name('create');
  //   Route::post('/', [InvoiceController::class, 'store'])->name('store');
  //   Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
  //   Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
  //   Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
  //   Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
  // });

  // routes/web.php
  Route::prefix('invoices')->name('invoice.')->middleware(['web', 'ensure-json-response'])->group(function () {
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
    Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
    Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
    Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
  });

  Route::get('/projects/{id_project}/detail', [ProjectController::class, 'show']);


  // Route::prefix('invoices')->name('invoices.')->group(function () {
  //   Route::get('/', [InvoiceController::class, 'index'])->name('index');
  //   Route::get('/create', [InvoiceController::class, 'create'])->name('create');
  //   Route::post('/', [InvoiceController::class, 'store'])->name('store');
  //   Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
  // });


});

require __DIR__ . '/auth.php';
