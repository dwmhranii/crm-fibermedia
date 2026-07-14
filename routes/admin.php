<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CoverageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\SettingController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // admin + superadmin
        Route::resource('packages', PackageController::class);
        Route::resource('coverages', CoverageController::class);

        // superadmin only
        Route::middleware('role:superadmin')->group(function () {
            Route::resource('faqs', FaqController::class);
            Route::resource('pages', PageController::class);
            Route::resource('banners', BannerController::class);

            Route::resource('gallery-albums', GalleryAlbumController::class);
            Route::resource('gallery-items', GalleryItemController::class);

            Route::resource('leads', LeadController::class)->only(['index','show','update','destroy']);

            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        });
    });
