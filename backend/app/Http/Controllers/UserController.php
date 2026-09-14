<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     */
    public function index(): JsonResponse
    {
        $users = User::select([
            'id',
            'nom',
            'prenom',
            'email',
            'role',
            'is_active',
            'created_at',
        ])
        ->orderBy('id', 'desc')
        ->get();
    
        return response()->json([
            'users' => $users,
        ]);
    }
    /**
     * Ajouter un nouvel utilisateur.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'user' => $user,
        ], 201);
    }
        /**
     * Modifier un utilisateur.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        // Si aucun nouveau mot de passe n'est fourni,
        // on conserve l'ancien.
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Utilisateur modifié avec succès.',
            'user' => $user->fresh(),
        ]);
    }
    public function toggleStatus(User $user): JsonResponse
    {
        // Empêcher un administrateur de désactiver son propre compte.
        if (auth()->id() === $user->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas désactiver votre propre compte.',
            ], 403);
        }
    
        $user->update([
            'is_active' => !$user->is_active,
        ]);
    
        return response()->json([
            'message' => $user->is_active
                ? 'Utilisateur activé avec succès.'
                : 'Utilisateur désactivé avec succès.',
            'user' => $user->fresh(),
        ]);
    }
}