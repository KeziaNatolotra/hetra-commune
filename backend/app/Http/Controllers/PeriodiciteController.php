<?php

namespace App\Http\Controllers;

use App\Models\Periodicite;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodiciteController extends Controller
{
    public function index(Request $request)
    {
        $query = Periodicite::query();

        if ($request->boolean('active_only')) {
            $query->where('is_active', true);
        }

        return response()->json($query->orderBy('libelle')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:periodicites,code',
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duree_jours' => 'nullable|integer|min:1',
        ]);

        $periodicite = Periodicite::create($validated + ['is_active' => true]);

        return response()->json($periodicite, 201);
    }

    public function show(Periodicite $periodicite)
    {
        return response()->json($periodicite);
    }

    public function update(Request $request, Periodicite $periodicite)
    {
        $validated = $request->validate([
            'code' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('periodicites', 'code')->ignore($periodicite->id)],
            'libelle' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'duree_jours' => 'nullable|integer|min:1',
        ]);

        $periodicite->update($validated);

        return response()->json($periodicite);
    }

    public function activate(Periodicite $periodicite)
    {
        $periodicite->update(['is_active' => true]);
        return response()->json($periodicite);
    }

    public function deactivate(Periodicite $periodicite)
    {
        $periodicite->update(['is_active' => false]);
        return response()->json($periodicite);
    }
}