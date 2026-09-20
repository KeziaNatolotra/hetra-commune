<?php

namespace App\Http\Controllers;

use App\Models\Obligation;
use App\Models\Taxe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ObligationController extends Controller
{
    public function index(Request $request)
    {
        $query = Obligation::with(['contribuable', 'taxe']);

        if ($request->filled('contribuable_id')) {
            $query->where('contribuable_id', $request->contribuable_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json(
            $query->orderByDesc('date_echeance')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contribuable_id' => 'required|exists:contribuables,id',
            'taxe_id' => 'required|exists:taxes,id',
            'affectation_id' => 'nullable|exists:affectations,id',
            'periode_debut' => 'required|date',
            'periode_fin' => 'nullable|date|after_or_equal:periode_debut',
            'date_echeance' => 'required|date',
            'montant_du' => 'nullable|numeric|min:0',
        ]);

        if (!isset($validated['montant_du'])) {
            $taxe = Taxe::findOrFail($validated['taxe_id']);
            $validated['montant_du'] = $taxe->montant;
        }

        $obligation = Obligation::create($validated + [
            'montant_paye' => 0,
            'statut' => 'a_payer',
        ]);

        return response()->json($obligation->load(['contribuable', 'taxe']), 201);
    }

    public function show(Obligation $obligation)
    {
        return response()->json($obligation->load(['contribuable', 'taxe', 'affectation']));
    }

    public function cancel(Request $request, Obligation $obligation)
    {
        $validated = $request->validate([
            'motif_annulation' => 'required|string|max:500',
        ]);

        $obligation->update([
            'statut' => 'annule',
            'motif_annulation' => $validated['motif_annulation'],
        ]);

        return response()->json($obligation);
    }
}