<?php

namespace App\Http\Controllers;

use App\Models\Contribuable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContribuableController extends Controller
{
    /**
     * Liste des contribuables.
     */
    public function index(): JsonResponse
    {
        $contribuables = Contribuable::orderBy('id', 'desc')->get();

        return response()->json([
            'contribuables' => $contribuables,
        ]);
    }

    /**
     * Ajouter un contribuable.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:contribuables,reference'],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'raison_sociale' => ['nullable', 'string', 'max:255'],
            'cin' => ['nullable', 'string', 'max:255'],
            'nif' => ['nullable', 'string', 'max:255'],
            'stat' => ['nullable', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string'],
            'fokontany_id' => ['nullable', 'integer'],
            'contribuable_type_id' => ['required', 'integer'],
            'zone_id' => ['nullable', 'integer'],
            'marche_id' => ['nullable', 'integer'],
            'activite' => ['nullable', 'string', 'max:255'],
            'emplacement' => ['nullable', 'string', 'max:255'],
            'date_inscription' => ['required', 'date'],
            'statut' => ['nullable', Rule::in(['actif', 'inactif'])],
        ]);

        $contribuable = Contribuable::create($validated);

        return response()->json([
            'message' => 'Contribuable créé avec succès.',
            'contribuable' => $contribuable,
        ], 201);
    }

    /**
     * Afficher un contribuable.
     */
    public function show(Contribuable $contribuable): JsonResponse
    {
        return response()->json([
            'contribuable' => $contribuable,
        ]);
    }

    /**
     * Modifier un contribuable.
     */
    public function update(Request $request, Contribuable $contribuable): JsonResponse
    {
        $validated = $request->validate([
            'reference' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contribuables', 'reference')
                    ->ignore($contribuable->id),
            ],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'raison_sociale' => ['nullable', 'string', 'max:255'],
            'cin' => ['nullable', 'string', 'max:255'],
            'nif' => ['nullable', 'string', 'max:255'],
            'stat' => ['nullable', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string'],
            'fokontany_id' => ['nullable', 'integer'],
            'contribuable_type_id' => ['required', 'integer'],
            'zone_id' => ['nullable', 'integer'],
            'marche_id' => ['nullable', 'integer'],
            'activite' => ['nullable', 'string', 'max:255'],
            'emplacement' => ['nullable', 'string', 'max:255'],
            'date_inscription' => ['required', 'date'],
            'statut' => ['nullable', Rule::in(['actif', 'inactif'])],
        ]);

        $contribuable->update($validated);

        return response()->json([
            'message' => 'Contribuable modifié avec succès.',
            'contribuable' => $contribuable->fresh(),
        ]);
    }

    /**
     * Activer / désactiver un contribuable.
     */
    public function toggleStatus(Contribuable $contribuable): JsonResponse
    {
        $contribuable->update([
            'statut' => $contribuable->statut === 'actif'
                ? 'inactif'
                : 'actif',
        ]);

        return response()->json([
            'message' => $contribuable->statut === 'actif'
                ? 'Contribuable activé avec succès.'
                : 'Contribuable désactivé avec succès.',
            'contribuable' => $contribuable->fresh(),
        ]);
    }
}