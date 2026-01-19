<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Application;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function store(Offer $offer)
    {
        if (!Gate::allows('apply-offer')) {
            abort(403, "Seuls les étudiants peuvent postuler.");
        }
        // 1. Vérifier si l'utilisateur a déjà postulé
        $exists = Application::where('user_id', Auth::id())
                             ->where('offer_id', $offer->id)
                             ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre !');
        }

        // 2. Créer la candidature
        Application::create([
            'user_id' => Auth::id(), // L'utilisateur connecté
            'offer_id' => $offer->id
        ]);

        // 3. Rediriger avec succès
        return back()->with('success', 'Votre candidature a été envoyée !');
    }
}
