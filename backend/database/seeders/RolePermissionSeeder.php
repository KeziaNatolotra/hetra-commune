<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'nom');
        $permissions = DB::table('permissions')->pluck('id', 'nom');

        // =====================================================
        // ADMIN
        // Toutes les permissions
        // =====================================================
        $adminPermissions = $permissions->values();

        foreach ($adminPermissions as $permissionId) {
            DB::table('role_permissions')->updateOrInsert(
                [
                    'role_id' => $roles['admin'],
                    'permission_id' => $permissionId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // =====================================================
        // RESPONSABLE FINANCIERE
        // =====================================================
        $responsableFinancierePermissions = [
            'contribuables.create',
            'contribuables.view',
            'contribuables.edit',

            'qr.generate',
            'qr.verify',
            'qr.deactivate',

            'taxes.create',
            'taxes.view',
            'taxes.edit',
            'taxes.activate',
            'taxes.deactivate',

            'periodicites.create',
            'periodicites.view',
            'periodicites.edit',
            'periodicites.activate',
            'periodicites.deactivate',

            'affectations.create',
            'affectations.view',

            'obligations.generate',
            'obligations.view',
            'obligations.cancel',
            'obligations.control',

            'paiements.view',
            'paiements.initiate',
            'paiements.verify',

            'transactions.supervise',
            'transactions.view',
            'transactions.anomalies',

            'recus.view',
            'recus.verify',
            'recus.download',

            'controles.view',
            'controles.register',

            'rapports.generate',
            'rapports.view',
            'rapports.export',

            'audit.view',
        ];

        $this->assignPermissions(
            $roles['responsable_financiere'],
            $responsableFinancierePermissions,
            $permissions
        );

        // =====================================================
        // RESPONSABLE COMMUNAL
        // =====================================================
        $responsableCommunalPermissions = [
            'contribuables.view',

            'qr.verify',

            'taxes.view',

            'obligations.view',

            'paiements.view',

            'recus.view',
            'recus.verify',

            'controles.view',

            'rapports.view',
            'rapports.generate',

            'notifications.view',
        ];

        $this->assignPermissions(
            $roles['responsable_communal'],
            $responsableCommunalPermissions,
            $permissions
        );

        // =====================================================
        // AGENT COLLECTEUR
        // =====================================================
        $agentCollecteurPermissions = [
            'contribuables.view',

            'qr.verify',

            'obligations.view',

            'paiements.initiate',

            'recus.verify',

            'controles.register',

            'offline.sync',

            'history.view',
        ];

        $this->assignPermissions(
            $roles['agent_collecteur'],
            $agentCollecteurPermissions,
            $permissions
        );

        // =====================================================
        // CONTRIBUABLE
        // =====================================================
        $contribuablePermissions = [
            'profile.view',
            'profile.edit',

            'qr.view',

            'taxes.view',

            'obligations.view',

            'paiements.initiate',

            'transactions.view',

            'recus.view',
            'recus.download',

            'notifications.view',

            'history.view',
        ];

        $this->assignPermissions(
            $roles['contribuable'],
            $contribuablePermissions,
            $permissions
        );
    }

    /**
     * Attribue plusieurs permissions à un rôle.
     */
    private function assignPermissions(
        int $roleId,
        array $permissionNames,
        $permissions
    ): void {
        foreach ($permissionNames as $permissionName) {

            if (!isset($permissions[$permissionName])) {
                continue;
            }

            DB::table('role_permissions')->updateOrInsert(
                [
                    'role_id' => $roleId,
                    'permission_id' => $permissions[$permissionName],
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}