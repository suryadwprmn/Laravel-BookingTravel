<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageBankController;
use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\PackageTourController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    // Admin routes
    Route::prefix('admin.')->group(function(){
        // Category routes
        //Ini adalah route yang hanya bisa diakses oleh user yang memiliki permission 'manage categories'
        Route::middleware('can:manage categories')->group(function(){
            Route::resource('categories', CategoryController::class);
        });

        // Package routes
        Route::middleware('can:manage packages')-> group(function(){
            Route::resource('packages',PackageTourController::class);
        });

        // Package Bank routes
        Route::middleware('can:manage packages banks')-> group(function(){
            Route::resource('package_banks', PackageBankController::class);
        });

        // Package Booking routes
        Route::middleware('can:manage transactions')->group(function(){
            Route::resource('transactions', PackageBookingController::class);
        });


    });
});

require __DIR__.'/auth.php';
