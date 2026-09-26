<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PackagesController;
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
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\PackageOrderController;
use App\Http\Controllers\Admin\WhyCardController;
use App\Http\Controllers\Public\AddonsController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Public\SimulationController;


// publik
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/packages', [PackagesController::class, 'index'])->name('public.packages'); 
Route::get('/packages/{package:slug}', [PackagesController::class, 'show'])->name('public.packages.show');

Route::get('/faq', [\App\Http\Controllers\Public\FaqController::class, 'index'])->name('public.faq');
Route::get('/profil', [ProfileController::class, 'index'])->name('public.profil');
Route::get('/coverage', [\App\Http\Controllers\Public\CoverageController::class, 'index'])->name('public.coverage');

Route::get('/addons', [AddonsController::class, 'index'])->name('public.addons');
Route::get('/simulasi-biaya', [SimulationController::class, 'index'])->name('public.simulation');

Route::prefix('order')->name('public.order.')->group(function () {
    Route::get('/start', [PackageOrderController::class, 'step1'])->name('step1');
    Route::post('/start', [PackageOrderController::class, 'storeStep1'])->name('storeStep1');

    Route::get('/customer', [PackageOrderController::class, 'step2'])->name('step2');
    Route::post('/customer', [PackageOrderController::class, 'storeStep2'])->name('storeStep2');

    Route::get('/confirm', [PackageOrderController::class, 'step3'])->name('step3');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD alias (Breeze default)
|--------------------------------------------------------------------------
| Setelah login, Breeze redirect ke route('dashboard')
| Kita arahkan ke admin.dashboard untuk role admin/superadmin
*/
// Route::middleware('auth')->get('/dashboard', function () {
//     $slug = Auth::user()?->role?->slug;

//     if (in_array($slug, ['admin', 'superadmin'], true)) {
//         return redirect()->route('admin.dashboard');
//     }

//     return redirect()->route('home');
// })->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web','auth','role:admin,superadmin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Route::resource('packages', PackageController::class);
        Route::resource('packages', PackageController::class);

        Route::resource('addons', AddonController::class);

        Route::resource('coverages', CoverageController::class);
        
        Route::resource('why-cards', WhyCardController::class);

        Route::middleware('role:superadmin')->group(function () {
            Route::resource('faqs', FaqController::class);
            Route::resource('pages', PageController::class);
            Route::resource('banners', BannerController::class);

            Route::resource('gallery-albums', GalleryAlbumController::class);
            Route::resource('gallery-items', GalleryItemController::class);

            Route::resource('leads', LeadController::class)->only(['index','show','update','destroy']);

            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

            Route::resource('users', UserController::class);
        });
    });



require __DIR__.'/auth.php';
