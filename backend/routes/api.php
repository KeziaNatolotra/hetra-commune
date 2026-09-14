<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContribuableController;
use App\Http\Controllers\ContribuableTypeController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API fonctionne',
    ]);
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    // Utilisateur connecté + ses permissions
    Route::get('/user', function (Request $request) {
        $user = $request->user();

        $permissions = \DB::table('role_permissions')
            ->join('roles', 'roles.id', '=', 'role_permissions.role_id')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('roles.nom', $user->role)
            ->where('permissions.is_active', true)
            ->pluck('permissions.nom')
            ->values();

        return response()->json([
            'user' => $user,
            'permissions' => $permissions,
        ]);
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Routes réservées à l'administrateur
    Route::middleware('admin')->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users', [UserController::class, 'index']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    });

    // Contribuables
    Route::get('/contribuables', [ContribuableController::class, 'index'])
        ->middleware('permission:contribuables.view');

    Route::post('/contribuables', [ContribuableController::class, 'store'])
        ->middleware('permission:contribuables.create');

    Route::get('/contribuables/{contribuable}', [ContribuableController::class, 'show']);

    Route::put('/contribuables/{contribuable}', [ContribuableController::class, 'update'])
        ->middleware('permission:contribuables.edit');

    Route::patch('/contribuables/{contribuable}/toggle-status', [ContribuableController::class, 'toggleStatus'])
        ->middleware('permission:contribuables.deactivate');

    // Types de contribuables
    Route::get('/contribuable-types', [ContribuableTypeController::class, 'index']);
});