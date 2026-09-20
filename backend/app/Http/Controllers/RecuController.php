<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use Illuminate\Http\Request;

class RecuController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Recu::with('paiement.obligation.contribuable', 'paiement.obligation.taxe')
                ->orderByDesc('date_emission')
                ->get()
        );
    }

    public function show(Recu $recu)
    {
        return response()->json(
            $recu->load('paiement.obligation.contribuable', 'paiement.obligation.taxe')
        );
    }

    /**
     * Vérification d'un reçu par son numéro (scan QR par un contrôleur).
     */
    public function verifier(string $numeroRecu)
    {
        $recu = Recu::with('paiement.obligation.contribuable', 'paiement.obligation.taxe')
            ->where('numero_recu', $numeroRecu)
            ->first();

        if (!$recu) {
            return response()->json(['valide' => false, 'message' => 'Reçu inconnu.'], 404);
        }

        if ($recu->statut === 'annule') {
            return response()->json([
                'valide' => false,
                'message' => 'Ce reçu a été annulé.',
                'recu' => $recu,
            ], 200);
        }

        return response()->json(['valide' => true, 'recu' => $recu]);
    }
}