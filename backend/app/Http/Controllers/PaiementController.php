<?php

namespace App\Http\Controllers;

use App\Models\Obligation;
use App\Models\Paiement;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with(['obligation', 'transaction', 'initiateur']);

        if ($request->filled('obligation_id')) {
            $query->where('obligation_id', $request->obligation_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obligation_id' => 'required|exists:obligations,id',
            'montant' => 'nullable|numeric|min:0.01',
        ]);

        $obligation = Obligation::findOrFail($validated['obligation_id']);
        $resteAPayer = $obligation->montant_du - $obligation->montant_paye;
        $montant = $validated['montant'] ?? $resteAPayer;

        if ($montant > $resteAPayer) {
            return response()->json([
                'message' => 'Le montant dépasse le reste à payer sur cette obligation.',
            ], 422);
        }

        $paiement = Paiement::create([
            'obligation_id' => $obligation->id,
            'initiateur_id' => $request->user()->id,
            'montant' => $montant,
            'moyen' => 'mobile_money',
            'statut' => 'pending',
        ]);

        $transaction = Transaction::create([
            'paiement_id' => $paiement->id,
            'reference_externe' => 'HTK-TXN-' . now()->format('Y') . '-' . str_pad((string) $paiement->id, 5, '0', STR_PAD_LEFT),
            'statut' => 'pending',
        ]);

        return response()->json($paiement->load('transaction', 'obligation'), 201);
    }

    public function show(Paiement $paiement)
    {
        return response()->json($paiement->load(['obligation', 'transaction', 'initiateur']));
    }
}