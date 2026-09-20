<?php

namespace App\Http\Controllers;

use App\Models\Contribuable;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = QrCode::with('contribuable');

        if ($request->filled('contribuable_id')) {
            $query->where('contribuable_id', $request->contribuable_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    /**
     * Génère un nouveau QR code pour un contribuable.
     * Désactive automatiquement l'ancien s'il en existait un actif.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contribuable_id' => 'required|exists:contribuables,id',
        ]);

        $contribuable = Contribuable::findOrFail($validated['contribuable_id']);

        // Désactive l'éventuel QR code encore actif de ce contribuable
        QrCode::where('contribuable_id', $contribuable->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'desactive_at' => now(),
            ]);

        $qrCode = QrCode::create([
            'contribuable_id' => $contribuable->id,
            'code' => 'HTK-QR-' . Str::upper(Str::random(12)),
            'is_active' => true,
            'genere_at' => now(),
        ]);

        return response()->json($qrCode->load('contribuable'), 201);
    }

    public function deactivate(QrCode $qrCode)
    {
        $qrCode->update([
            'is_active' => false,
            'desactive_at' => now(),
        ]);

        return response()->json($qrCode);
    }

    /**
     * "Scan" du QR code — renvoie la situation du contribuable.
     * Ne renvoie aucune donnée si le code est invalide ou désactivé.
     */
    public function verifier(string $code)
    {
        $qrCode = QrCode::with('contribuable')
            ->where('code', $code)
            ->first();

        if (!$qrCode) {
            return response()->json(['valide' => false, 'message' => 'QR code inconnu.'], 404);
        }

        if (!$qrCode->is_active) {
            return response()->json([
                'valide' => false,
                'message' => 'Ce QR code a été désactivé.',
            ], 200);
        }

        return response()->json([
            'valide' => true,
            'contribuable' => $qrCode->contribuable,
        ]);
    }
}