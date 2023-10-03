<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/', [HomeController::class, 'store'])->name('url.store');
    Route::get('/edit/{url}', [HomeController::class, 'edit'])->name('edit');
    Route::post('/edit/{url}', [HomeController::class, 'update'])->name('update');



    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    Route::middleware('auth')->name('payment.')->group(function () {
        Route::get('/pay', [PaymentController::class, 'index'])->name('index');
        Route::post('/pay/initiate-payment', [PaymentController::class, 'initiate'])->name('initiate');
        Route::get('/pay/payment-callback', [PaymentController::class, 'payment_callback'])->name('callback');

    });
    

});

require __DIR__.'/auth.php';
