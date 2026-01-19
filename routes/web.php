<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Models\Offer;
use App\Models\Skill;
use Illuminate\Support\Facades\Route;


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

    $offers = Offer::latest()->take(6)->get();
    return view('welcome', ['offers' => $offers]);
});

// Index public des offres (filtrage par skills, recherche, tri)
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user->role === 'student') {
        $applications = $user->applications()->with('offer')->latest()->get();

        // Offres publiques filtrables pour l'étudiant
        $query = Offer::query()->with('skills')->withCount('applications');

        if (request()->filled('q')) {
            $query->where('title', 'like', '%' . request('q') . '%');
        }

        if (request()->has('skills')) {
            $skillIds = array_filter((array)request('skills'));
            if (!empty($skillIds)) {
                $query->whereHas('skills', function ($q,) use ($skillIds) {
                    $q->whereIn('skills.id', $skillIds);
                });
            }
        }

        if (request()->filled('sort')) {
            $sort = request('sort');
            if ($sort === 'applications_asc') {
                $query->orderBy('applications_count', 'asc');
            } else if ($sort === 'applications_desc') {
                $query->orderBy('applications_count', 'desc');
            } else if ($sort === 'title_asc') {
                $query->orderBy('title', 'asc');
            } else if ($sort === 'title_desc') {
                $query->orderBy('title', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $offers = $query->paginate(10)->withQueryString();
        $allSkills = Skill::orderBy('name')->get();

        return view('dashboard', ['applications' => $applications, 'offers' => $offers, 'allSkills' => $allSkills]);
    }

    // Pour les companies, permettre filtrage local via query params
    $query = Offer::query()->where('user_id', $user->id)->with(['skills', 'applications.user'])->withCount('applications');

    // Recherche par titre
    if (request()->filled('q')) {
        $query->where('title', 'like', '%' . request('q') . '%');
    }

    // Filtre par skills (any match)
    if (request()->has('skills')) {
        $skillIds = array_filter((array)request('skills'));
        if (!empty($skillIds)) {
            $query->whereHas('skills', function ($q,) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            });
        }
    }

    // Tri
    if (request()->filled('sort')) {
        $sort = request('sort');
        if ($sort === 'applications_asc') {
            $query->orderBy('applications_count', 'asc');
        } else if ($sort === 'applications_desc') {
            $query->orderBy('applications_count', 'desc');
        } else if ($sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } else if ($sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest();
        }
    } else {
        $query->latest();
    }

    $offers = $query->get();
    $allSkills = Skill::orderBy('name')->get();

    return view('dashboard', ['offers' => $offers, 'allSkills' => $allSkills]);

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Endpoint pour récupérer les skills (autocomplete)
Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');

require __DIR__ . '/auth.php';
