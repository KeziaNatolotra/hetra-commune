<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::upsert(
            [

            // =========================
            // UTILISATEURS
            // =========================
            [
                'nom' => 'users.create',
                'description' => 'Créer un utilisateur',
                'is_active' => true,
            ],
            [
                'nom' => 'users.view',
                'description' => 'Consulter les utilisateurs',
                'is_active' => true,
            ],
            [
                'nom' => 'users.edit',
                'description' => 'Modifier un utilisateur',
                'is_active' => true,
            ],
            [
                'nom' => 'users.deactivate',
                'description' => 'Désactiver un utilisateur',
                'is_active' => true,
            ],

            // =========================
            // RÔLES
            // =========================
            [
                'nom' => 'roles.create',
                'description' => 'Créer un rôle',
                'is_active' => true,
            ],
            [
                'nom' => 'roles.view',
                'description' => 'Consulter les rôles',
                'is_active' => true,
            ],
            [
                'nom' => 'roles.edit',
                'description' => 'Modifier un rôle',
                'is_active' => true,
            ],
            [
                'nom' => 'roles.delete',
                'description' => 'Supprimer un rôle',
                'is_active' => true,
            ],
            [
                'nom' => 'roles.deactivate',
                'description' => 'Désactiver un rôle',
                'is_active' => true,
            ],

            // =========================
            // PERMISSIONS
            // =========================
            [
                'nom' => 'permissions.view',
                'description' => 'Consulter les permissions',
                'is_active' => true,
            ],
            [
                'nom' => 'permissions.manage',
                'description' => 'Ajouter, retirer et modifier les permissions d’un rôle',
                'is_active' => true,
            ],

            // =========================
            // CONTRIBUABLES
            // =========================
            [
                'nom' => 'contribuables.create',
                'description' => 'Ajouter un contribuable',
                'is_active' => true,
            ],
            [
                'nom' => 'contribuables.view',
                'description' => 'Consulter les contribuables',
                'is_active' => true,
            ],
            [
                'nom' => 'contribuables.edit',
                'description' => 'Modifier un contribuable',
                'is_active' => true,
            ],
            [
                'nom' => 'contribuables.deactivate',
                'description' => 'Désactiver un contribuable',
                'is_active' => true,
            ],

            // =========================
            // QR
            // =========================
            [
                'nom' => 'qr.generate',
                'description' => 'Générer un QR code',
                'is_active' => true,
            ],
            [
                'nom' => 'qr.view',
                'description' => 'Consulter un QR code',
                'is_active' => true,
            ],
            [
                'nom' => 'qr.deactivate',
                'description' => 'Désactiver un QR code',
                'is_active' => true,
            ],
            [
                'nom' => 'qr.verify',
                'description' => 'Vérifier un QR code',
                'is_active' => true,
            ],

            // =========================
            // TAXES
            // =========================
            [
                'nom' => 'taxes.create',
                'description' => 'Créer une taxe',
                'is_active' => true,
            ],
            [
                'nom' => 'taxes.view',
                'description' => 'Consulter les taxes',
                'is_active' => true,
            ],
            [
                'nom' => 'taxes.edit',
                'description' => 'Modifier une taxe',
                'is_active' => true,
            ],
            [
                'nom' => 'taxes.activate',
                'description' => 'Activer une taxe',
                'is_active' => true,
            ],
            [
                'nom' => 'taxes.deactivate',
                'description' => 'Désactiver une taxe',
                'is_active' => true,
            ],

            // =========================
            // PÉRIODICITÉS
            // =========================
            [
                'nom' => 'periodicites.create',
                'description' => 'Créer une périodicité',
                'is_active' => true,
            ],
            [
                'nom' => 'periodicites.view',
                'description' => 'Consulter les périodicités',
                'is_active' => true,
            ],
            [
                'nom' => 'periodicites.edit',
                'description' => 'Modifier une périodicité',
                'is_active' => true,
            ],
            [
                'nom' => 'periodicites.activate',
                'description' => 'Activer une périodicité',
                'is_active' => true,
            ],
            [
                'nom' => 'periodicites.deactivate',
                'description' => 'Désactiver une périodicité',
                'is_active' => true,
            ],

            // =========================
            // AFFECTATIONS
            // =========================
            [
                'nom' => 'affectations.create',
                'description' => 'Affecter une taxe à un contribuable, une zone ou une catégorie',
                'is_active' => true,
            ],
            [
                'nom' => 'affectations.view',
                'description' => 'Consulter les affectations',
                'is_active' => true,
            ],

            // =========================
            // OBLIGATIONS
            // =========================
            [
                'nom' => 'obligations.generate',
                'description' => 'Générer une obligation fiscale',
                'is_active' => true,
            ],
            [
                'nom' => 'obligations.view',
                'description' => 'Consulter les obligations',
                'is_active' => true,
            ],
            [
                'nom' => 'obligations.cancel',
                'description' => 'Annuler une obligation',
                'is_active' => true,
            ],
            [
                'nom' => 'obligations.control',
                'description' => 'Contrôler une obligation',
                'is_active' => true,
            ],

            // =========================
            // PAIEMENTS
            // =========================
            [
                'nom' => 'paiements.view',
                'description' => 'Consulter les paiements',
                'is_active' => true,
            ],
            [
                'nom' => 'paiements.initiate',
                'description' => 'Initier un paiement',
                'is_active' => true,
            ],
            [
                'nom' => 'paiements.verify',
                'description' => 'Vérifier un paiement',
                'is_active' => true,
            ],

            // =========================
            // TRANSACTIONS
            // =========================
            [
                'nom' => 'transactions.supervise',
                'description' => 'Superviser les transactions',
                'is_active' => true,
            ],
            [
                'nom' => 'transactions.view',
                'description' => 'Consulter les transactions',
                'is_active' => true,
            ],
            [
                'nom' => 'transactions.verify',
                'description' => 'Vérifier une transaction',
                'is_active' => true,
            ],
            [
                'nom' => 'transactions.anomalies',
                'description' => 'Gérer les anomalies des transactions',
                'is_active' => true,
            ],

            // =========================
            // REÇUS
            // =========================
            [
                'nom' => 'recus.view',
                'description' => 'Consulter les reçus',
                'is_active' => true,
            ],
            [
                'nom' => 'recus.verify',
                'description' => 'Vérifier un reçu',
                'is_active' => true,
            ],
            [
                'nom' => 'recus.print',
                'description' => 'Imprimer un reçu',
                'is_active' => true,
            ],
            [
                'nom' => 'recus.download',
                'description' => 'Télécharger un reçu',
                'is_active' => true,
            ],

            // =========================
            // AGENTS
            // =========================
            [
                'nom' => 'agents.create',
                'description' => 'Ajouter un agent collecteur',
                'is_active' => true,
            ],
            [
                'nom' => 'agents.view',
                'description' => 'Consulter les agents',
                'is_active' => true,
            ],
            [
                'nom' => 'agents.edit',
                'description' => 'Modifier un agent',
                'is_active' => true,
            ],
            [
                'nom' => 'agents.assign_zone',
                'description' => 'Affecter un agent à une zone',
                'is_active' => true,
            ],
            [
                'nom' => 'agents.deactivate',
                'description' => 'Désactiver un agent',
                'is_active' => true,
            ],

            // =========================
            // ZONES / FOKONTANY / MARCHÉS
            // =========================
            [
                'nom' => 'zones.create',
                'description' => 'Créer une zone',
                'is_active' => true,
            ],
            [
                'nom' => 'zones.view',
                'description' => 'Consulter les zones',
                'is_active' => true,
            ],
            [
                'nom' => 'zones.edit',
                'description' => 'Modifier une zone',
                'is_active' => true,
            ],
            [
                'nom' => 'zones.deactivate',
                'description' => 'Désactiver une zone',
                'is_active' => true,
            ],

            [
                'nom' => 'fokontany.create',
                'description' => 'Créer un fokontany',
                'is_active' => true,
            ],
            [
                'nom' => 'fokontany.view',
                'description' => 'Consulter les fokontany',
                'is_active' => true,
            ],
            [
                'nom' => 'fokontany.edit',
                'description' => 'Modifier un fokontany',
                'is_active' => true,
            ],
            [
                'nom' => 'fokontany.deactivate',
                'description' => 'Désactiver un fokontany',
                'is_active' => true,
            ],

            [
                'nom' => 'marches.create',
                'description' => 'Créer un marché',
                'is_active' => true,
            ],
            [
                'nom' => 'marches.view',
                'description' => 'Consulter les marchés',
                'is_active' => true,
            ],
            [
                'nom' => 'marches.edit',
                'description' => 'Modifier un marché',
                'is_active' => true,
            ],
            [
                'nom' => 'marches.deactivate',
                'description' => 'Désactiver un marché',
                'is_active' => true,
            ],

            // =========================
            // CONTRÔLES
            // =========================
            [
                'nom' => 'controles.supervise',
                'description' => 'Superviser les contrôles',
                'is_active' => true,
            ],
            [
                'nom' => 'controles.view',
                'description' => 'Consulter les contrôles',
                'is_active' => true,
            ],
            [
                'nom' => 'controles.register',
                'description' => 'Enregistrer un résultat ou une observation de contrôle',
                'is_active' => true,
            ],
            [
                'nom' => 'controles.analyze',
                'description' => 'Analyser les contrôles',
                'is_active' => true,
            ],

            // =========================
            // RAPPORTS
            // =========================
            [
                'nom' => 'rapports.generate',
                'description' => 'Générer un rapport',
                'is_active' => true,
            ],
            [
                'nom' => 'rapports.view',
                'description' => 'Consulter les rapports',
                'is_active' => true,
            ],
            [
                'nom' => 'rapports.export',
                'description' => 'Exporter un rapport',
                'is_active' => true,
            ],

            // =========================
            // AUDIT
            // =========================
            [
                'nom' => 'audit.view',
                'description' => 'Consulter les journaux d’audit',
                'is_active' => true,
            ],
            [
                'nom' => 'audit.actions',
                'description' => 'Consulter les actions enregistrées',
                'is_active' => true,
            ],
            [
                'nom' => 'audit.modifications',
                'description' => 'Consulter les modifications enregistrées',
                'is_active' => true,
            ],

            // =========================
            // NOTIFICATIONS
            // =========================
            [
                'nom' => 'notifications.view',
                'description' => 'Consulter les notifications',
                'is_active' => true,
            ],
            [
                'nom' => 'notifications.configure',
                'description' => 'Configurer les notifications',
                'is_active' => true,
            ],

            // =========================
            // PROFIL CONTRIBUABLE
            // =========================
            [
                'nom' => 'profile.view',
                'description' => 'Consulter son profil',
                'is_active' => true,
            ],
            [
                'nom' => 'profile.edit',
                'description' => 'Modifier les informations autorisées de son profil',
                'is_active' => true,
            ],

            // =========================
            // MODE HORS LIGNE
            // =========================
            [
                'nom' => 'offline.sync',
                'description' => 'Synchroniser les données hors ligne',
                'is_active' => true,
            ],

            // =========================
            // HISTORIQUE
            // =========================
            [
                'nom' => 'history.view',
                'description' => 'Consulter son historique d’opérations',
                'is_active' => true,
            ],
        ],
        ['nom'],
        ['description', 'is_active']
        );
    }
}