<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RfqController as AdminRfqController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CertificateVerifyController;
use App\Http\Controllers\CustomerRfqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/sertifikat/cek/{code}', [CertificateVerifyController::class, 'show'])->name('certificates.verify');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('rfqs', CustomerRfqController::class)->only(['index', 'create', 'store', 'show']);
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show', 'destroy']);
    Route::resource('rfqs', AdminRfqController::class)->except(['show']);
    Route::resource('clients', ClientController::class)->only(['index', 'edit', 'update']);
    Route::resource('certificates', AdminCertificateController::class)->except(['show', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
