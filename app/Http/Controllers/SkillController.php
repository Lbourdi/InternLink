<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SkillController extends Controller
{
    // Renvoie la liste des skills sous forme JSON pour autocomplete
    public function index(Request $request)
    {
        $query = Skill::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('name', 'like', "%{$q}%");
        }

        $skills = $query->orderBy('name')->limit(50)->get(['id', 'name']);

        return response()->json($skills);
    }
}
