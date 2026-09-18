<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        $query = Affectation::query()->with(['taxe', 'contribuable', 'contribuableType']);

        if ($request->boolean('active_only')) {
            $query->where('is_active', true);
        }

        return response()->json($query->orderByDesc('id')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'taxe_id' => 'required|exists:taxes,id',
            'contribuable_id' => 'nullable|exists:contribuables,id',
            'contribuable_type_id' => 'nullable|exists:contribuable_types,id',
            'zone_id' => 'nullable|integer',
        ]);

        if (
            empty($validated['contribuable_id']) &&
            empty($validated['contribuable_type_id']) &&
            empty($validated['zone_id'])
        ) {
            return response()->json([
                'message' => 'Vous devez préciser au moins un contribuable, une catégorie ou une zone.',
                'errors' => [
                    'cible' => ['Une affectation doit cibler un contribuable, une catégorie ou une zone.'],
                ],
            ], 422);
        }

        $affectation = Affectation::create($validated + ['is_active' => true]);

        return response()->json(
            $affectation->load(['taxe', 'contribuable', 'contribuableType']),
            201
        );
    }

    public function show(Affectation $affectation)
    {
        return response()->json(
            $affectation->load(['taxe', 'contribuable', 'contribuableType'])
        );
    }

    public function deactivate(Affectation $affectation)
    {
        $affectation->update(['is_active' => false]);
        return response()->json($affectation);
    }
}