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

  Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
  Route::get('/invoice', [InvoiceController::class, 'datatable'])->name('invoices.datatable');

  // routes/web.php
  Route::prefix('invoices')->name('invoices.')->middleware(['web', 'ensure-json-response'])->group(function () {
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');

    Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
    Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
    Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
  });
  Route::get('/invoices/project/{project}', [InvoiceController::class, 'showByProject'])->name('invoices.show.project');

  Route::get('/projects/{project}/detail', [ProjectController::class, 'showJson'])->name('showJson');
  Route::get('/projects/select2', [ProjectController::class, 'select2Available'])
    ->name('projects.select2');
  Route::get('/projects/{project}/json', [ProjectController::class, 'showJson'])->name('projects.show.json');


  Route::prefix('projects')->name('projects.')->middleware(['web', 'ensure-json-response'])->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/datatable', [ProjectController::class, 'datatable'])->name('datatable');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/', [ProjectController::class, 'store'])->name('store');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
  });


});

require __DIR__ . '/auth.php';
