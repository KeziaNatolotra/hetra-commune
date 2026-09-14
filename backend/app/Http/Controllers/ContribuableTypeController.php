<?php

namespace App\Http\Controllers;

use App\Models\ContribuableType;
use Illuminate\Http\JsonResponse;

class ContribuableTypeController extends Controller
{
    /**
     * Liste des types de contribuables.
     */
    public function index(): JsonResponse
    {
        $types = ContribuableType::orderBy('nom')->get([
            'id',
            'nom',
        ]);

        return response()->json([
            'contribuable_types' => $types,
        ]);
    }
}