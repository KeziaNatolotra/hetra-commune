<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaxeController extends Controller
{
    private array $periodicites = [
        'journaliere', 'hebdomadaire', 'mensuelle', 'trimestrielle',
        'semestrielle', 'annuelle', 'ponctuelle', 'personnalisee',
    ];

    public function index(Request $request)
    {
        $query = Taxe::query()->with('contribuableType');

        if ($request->boolean('active_only')) {
            $query->where('is_active', true);
        }

        return response()->json($query->orderBy('libelle')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:taxes,code',
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'periodicite' => ['required', Rule::in($this->periodicites)],
            'contribuable_type_id' => 'nullable|exists:contribuable_types,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        $taxe = Taxe::create($validated + ['is_active' => true]);

        return response()->json($taxe->load('contribuableType'), 201);
    }

    public function show(Taxe $taxe)
    {
        return response()->json($taxe->load('contribuableType'));
    }

    public function update(Request $request, Taxe $taxe)
    {
        $validated = $request->validate([
            'code' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('taxes', 'code')->ignore($taxe->id)],
            'libelle' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'sometimes|required|numeric|min:0',
            'periodicite' => ['sometimes', 'required', Rule::in($this->periodicites)],
            'contribuable_type_id' => 'nullable|exists:contribuable_types,id',
            'date_debut' => 'sometimes|required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        $taxe->update($validated);

        return response()->json($taxe->load('contribuableType'));
    }

    public function activate(Taxe $taxe)
    {
        $taxe->update(['is_active' => true]);
        return response()->json($taxe);
    }

    public function deactivate(Taxe $taxe)
    {
        $taxe->update(['is_active' => false]);
        return response()->json($taxe);
    }
}