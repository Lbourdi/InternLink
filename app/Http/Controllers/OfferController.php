<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class OfferController extends Controller
{
    // 1. Formulaire de création
    public function create()
    {
        return view('offers.create');
    }

    // 2. Enregistrer la nouvelle offre
    public function store(Request $request,)
    {
        $validated = $request->validate([
            'title'        => 'required|max:255',
            'company_name' => 'required|max:255',
            'description'  => 'required',
        ]);

        // Création
        Offer::create([
            'title'        => $request->title,
            'company_name' => $request->company_name,
            'description'  => $request->description,
            'user_id'      => Auth::id(), // L'utilisateur connecté
        ]);

        return redirect('/dashboard')->with('success', 'Offre créée avec succès !');
    }

    // 3. Formulaire de modification
    public function edit(Offer $offer,)
    {
        // Vérification sécurité (Gate)
        if (!Gate::allows('manage-offer', $offer)) {
            abort(403);
        }
        return view('offers.edit', ['offer' => $offer]);
    }

    // 4. Mettre à jour l'offre
    public function update(Request $request, Offer $offer,)
    {
        if (!Gate::allows('manage-offer', $offer)) {
            abort(403);
        }

        $validated = $request->validate([
            'title'        => 'required|max:255',
            'company_name' => 'required|max:255',
            'description'  => 'required',
        ]);

        $offer->update($validated);

        return redirect('/dashboard')->with('success', 'Offre mise à jour !');
    }

    // 5. Supprimer l'offre
    public function destroy(Offer $offer,)
    {
        if (!Gate::allows('manage-offer', $offer)) {
            abort(403);
        }

        $offer->delete();

        return redirect('/dashboard')->with('success', 'Offre supprimée.');
    }

    public function show(Offer $offer,)
    {
        return view('offers.show', ['offer' => $offer]);
    }
}
