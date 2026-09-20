<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Recu;

class MockMobileMoneyController extends Controller
{
    /**
     * Simule le callback envoyé par l'opérateur Mobile Money.
     * En vrai production, cette route serait appelée par l'opérateur externe,
     * pas par le frontend — ici on la déclenche manuellement pour simuler.
     */
    public function callback(Request $request, string $referenceExterne)
    {
        $validated = $request->validate([
            'resultat' => 'required|in:succes,echec',
        ]);

        $transaction = Transaction::where('reference_externe', $referenceExterne)->firstOrFail();

        // Empêche de traiter deux fois le même callback (double callback = anomalie)
        if ($transaction->statut !== 'pending') {
            return response()->json([
                'message' => 'Ce paiement a déjà été traité. Callback ignoré.',
            ], 409);
        }

        $transaction->update([
            'statut' => $validated['resultat'],
            'callback_recu_at' => now(),
            'callback_payload' => $request->all(),
        ]);

        $paiement = $transaction->paiement;
        $paiement->update(['statut' => $validated['resultat']]);

        if ($validated['resultat'] === 'succes') {
            $obligation = $paiement->obligation;
            $nouveauMontantPaye = $obligation->montant_paye + $paiement->montant;

            $obligation->update([
                'montant_paye' => $nouveauMontantPaye,
                'statut' => $nouveauMontantPaye >= $obligation->montant_du
                    ? 'paye'
                    : 'partiellement_paye',
            ]);
            Recu::create([
            'paiement_id' => $paiement->id,
            'numero_recu' => 'HTK-RCT-' . now()->format('Y') . '-' . str_pad((string) $paiement->id, 6, '0', STR_PAD_LEFT),
            'montant' => $paiement->montant,
            'date_emission' => now(),
            'statut' => 'valide',
            ]);
        }


        return response()->json($transaction->load('paiement.obligation'));
    }
}