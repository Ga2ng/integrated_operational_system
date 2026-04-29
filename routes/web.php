<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CertificationProgramController;
use App\Http\Controllers\Admin\InventoryMaterialController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RfqController as AdminRfqController;
use App\Http\Controllers\Admin\ProjectTaskController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CertificateVerifyController;
use App\Http\Controllers\CustomerRfqController;
use App\Http\Controllers\Customer\MyCertificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/katalog/{materialInventory}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/sertifikat/cek', [CertificateVerifyController::class, 'index'])->name('certificates.search');
Route::post('/sertifikat/cek', [CertificateVerifyController::class, 'search'])->name('certificates.search.post');
Route::get('/sertifikat/cek/{code}', [CertificateVerifyController::class, 'show'])->name('certificates.verify');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('rfqs', CustomerRfqController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('my-certifications', [MyCertificationController::class, 'index'])->name('my-certifications.index');
    Route::get('my-certifications/{participant}', [MyCertificationController::class, 'show'])->name('my-certifications.show');
    Route::post('my-certifications/{participant}', [MyCertificationController::class, 'store'])->name('my-certifications.store');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::resource('inventory-materials', InventoryMaterialController::class)
        ->parameters(['inventory-materials' => 'materialInventory'])
        ->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['destroy']);
    Route::post('projects/{project}/tasks', [ProjectTaskController::class, 'store'])->name('projects.tasks.store');
    Route::patch('projects/{project}/mark-completed', [ProjectController::class, 'markCompleted'])->name('projects.mark-completed');
    Route::patch('tasks/{projectTask}/status', [ProjectTaskController::class, 'updateStatus'])->name('tasks.status.update');
    Route::resource('rfqs', AdminRfqController::class)->except(['show']);
    Route::resource('certificates', AdminCertificateController::class)->except(['show', 'destroy']);
    
    // New Dynamic Certifications
    Route::resource('certification-programs', CertificationProgramController::class);
    Route::post('certification-programs/{program}/requirements', [CertificationProgramController::class, 'storeRequirement'])->name('certification-programs.requirements.store');
    Route::delete('certification-programs/requirements/{requirement}', [CertificationProgramController::class, 'destroyRequirement'])->name('certification-programs.requirements.destroy');
    Route::get('certification-programs/{program}/assign', [CertificationProgramController::class, 'assignParticipants'])->name('certification-programs.assign');
    Route::post('certification-programs/{program}/assign', [CertificationProgramController::class, 'storeParticipants'])->name('certification-programs.assign.store');
    Route::get('certification-programs/{program}/submissions', [CertificationProgramController::class, 'submissions'])->name('certification-programs.submissions');
    Route::get('certification-programs/submissions/{participant}', [CertificationProgramController::class, 'showSubmission'])->name('certification-programs.submissions.show');
    Route::patch('certification-programs/submissions/{participant}', [CertificationProgramController::class, 'updateSubmissionStatus'])->name('certification-programs.submissions.update-status');

    Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('users', UserManagementController::class)->only(['index', 'edit', 'update']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
