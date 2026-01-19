<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class OfferController extends Controller
{
    // 1. Formulaire de création
    public function create()
    {
        // Fournir la liste des skills pour le formulaire
        $skills = Skill::orderBy('name')->get();
        return view('offers.create', compact('skills'));
    }

    // 2. Enregistrer la nouvelle offre
    public function store(Request $request,)
    {
        $validated = $request->validate([
            'title'        => 'required|max:255',
            'company_name' => 'required|max:255',
            'description'  => 'required',
            'skills'       => 'nullable|array',
            'skills.*'     => 'integer|exists:skills,id',
        ]);

        // Création
        $offer = Offer::create([
            'title'        => $request->title,
            'company_name' => $request->company_name,
            'description'  => $request->description,
            'user_id'      => Auth::id(), // L'utilisateur connecté
        ]);

        // Associer les skills si fournis
        $skillIds = $request->input('skills', []);
        $offer->skills()->sync($skillIds);

        return redirect('/dashboard')->with('success', 'Offre créée avec succès !');
    }

    // 3. Formulaire de modification
    public function edit(Offer $offer,)
    {
        // Vérification sécurité (Gate)
        if (!Gate::allows('manage-offer', $offer)) {
            abort(403);
        }

        $skills = Skill::orderBy('name')->get();
        return view('offers.edit', ['offer' => $offer, 'skills' => $skills]);
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
            'skills'       => 'nullable|array',
            'skills.*'     => 'integer|exists:skills,id',
        ]);

        $offer->update($validated);

        // Synchroniser les skills
        $skillIds = $request->input('skills', []);
        $offer->skills()->sync($skillIds);

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
        $offer->load('skills', 'applications');
        return view('offers.show', ['offer' => $offer]);
    }

    // Index public des offres avec filtres par skills, recherche et tri
    public function index(Request $request)
    {
        $query = Offer::query()->with('skills')->withCount('applications');

        // Recherche par texte (titre)
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('title', 'like', "%{$q}%");
        }

        // Filtre par skills (match any)
        if ($request->has('skills')) {
            $skillIds = array_filter((array) $request->input('skills'));
            if (!empty($skillIds)) {
                $query->whereHas('skills', function ($q) use ($skillIds) {
                    $q->whereIn('skills.id', $skillIds);
                });
            }
        }

        // Tri
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'applications_asc') {
                $query->orderBy('applications_count', 'asc');
            } elseif ($sort === 'applications_desc') {
                $query->orderBy('applications_count', 'desc');
            } elseif ($sort === 'title_asc') {
                $query->orderBy('title', 'asc');
            } elseif ($sort === 'title_desc') {
                $query->orderBy('title', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $offers = $query->paginate(10)->withQueryString();

        // Liste des skills pour la barre de filtre
        $allSkills = Skill::orderBy('name')->get();

        return view('offers.index', ['offers' => $offers, 'allSkills' => $allSkills]);
    }
}
