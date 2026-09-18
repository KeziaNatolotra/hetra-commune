<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContribuableController;
use App\Http\Controllers\ContribuableTypeController;
use App\Http\Controllers\TaxeController;
use App\Http\Controllers\PeriodiciteController;

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
// Taxes
Route::get('/taxes', [TaxeController::class, 'index'])
    ->middleware('permission:taxes.view');

Route::post('/taxes', [TaxeController::class, 'store'])
    ->middleware('permission:taxes.create');

Route::get('/taxes/{taxe}', [TaxeController::class, 'show'])
    ->middleware('permission:taxes.view');

Route::put('/taxes/{taxe}', [TaxeController::class, 'update'])
    ->middleware('permission:taxes.edit');

Route::patch('/taxes/{taxe}/activate', [TaxeController::class, 'activate'])
    ->middleware('permission:taxes.activate');

Route::patch('/taxes/{taxe}/deactivate', [TaxeController::class, 'deactivate'])
    ->middleware('permission:taxes.deactivate');

    // Périodicités
    Route::get('/periodicites', [PeriodiciteController::class, 'index'])
        ->middleware('permission:periodicites.view');

    Route::post('/periodicites', [PeriodiciteController::class, 'store'])
        ->middleware('permission:periodicites.create');

    Route::get('/periodicites/{periodicite}', [PeriodiciteController::class, 'show'])
        ->middleware('permission:periodicites.view');

    Route::put('/periodicites/{periodicite}', [PeriodiciteController::class, 'update'])
        ->middleware('permission:periodicites.edit');

    Route::patch('/periodicites/{periodicite}/activate', [PeriodiciteController::class, 'activate'])
        ->middleware('permission:periodicites.activate');

    Route::patch('/periodicites/{periodicite}/deactivate', [PeriodiciteController::class, 'deactivate'])
        ->middleware('permission:periodicites.deactivate');