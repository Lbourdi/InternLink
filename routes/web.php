<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use App\Models\Offer;


Route::middleware(['auth'])->group(function () {
    // Création (ATTENTION : Doit être avant /{offer})
    Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    
    // Modification
    Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::patch('/offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');

    // Candidature
    Route::post('/offers/{offer}/apply', [ApplicationController::class, 'store'])->name('offers.apply');
});

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'company') {
        return redirect()->route('dashboard'); // On le force à aller sur son dashboard
    }

    $offers = \App\Models\Offer::latest()->take(6)->get();
    return view('welcome', ['offers' => $offers]);
});

Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user->role === 'student') {
        $applications = $user->applications()->with('offer')->latest()->get();
        
        return view('dashboard', ['applications' => $applications]);
    } 
    
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
