import { useEffect, useState } from "react";
import api from "../../api";
import EditUserForm from "./EditUserForm";

interface User {
    id: number;
    nom: string;
    prenom: string;
    email: string;
    role: string;
    is_active: boolean;
    created_at: string;
}

function UserList() {
    const [users, setUsers] = useState<User[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");
    const [selectedUser, setSelectedUser] = useState<User | null>(null);
    const [search, setSearch] = useState("");
    const fetchUsers = async () => {
        try {
            setLoading(true);
            setError("");
    
            const response = await api.get("/api/users");
    
            setUsers(response.data.users);
        } catch (error: any) {
            console.error(error);
            setError("Impossible de récupérer les utilisateurs.");
        } finally {
            setLoading(false);
        }
    };
    
    useEffect(() => {
        fetchUsers();
    }, []);

    if (loading) {
        return <p>Chargement des utilisateurs...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }
    if (selectedUser) {
        return (
            <EditUserForm
                user={selectedUser}
                onSuccess={async () => {
                    setSelectedUser(null);
                    await fetchUsers();
                }}
                onCancel={() => setSelectedUser(null)}
            />
        );
    }
    const handleToggleStatus = async (user: User) => {
        try {
            await api.patch(
                `/api/users/${user.id}/toggle-status`
            );
    
            setUsers((currentUsers) =>
                currentUsers.map((currentUser) =>
                    currentUser.id === user.id
                        ? {
                              ...currentUser,
                              is_active: !currentUser.is_active,
                          }
                        : currentUser
                )
            );
        } catch (error: any) {
            console.error(
                "Erreur lors du changement de statut :",
                error
            );
        
            if (error.response?.status === 403) {
                setError(
                    error.response.data?.message ||
                    "Vous n'êtes pas autorisé à effectuer cette action."
                );
            } else {
                setError(
                    "Impossible de modifier le statut de l'utilisateur."
                );
            }
        }
    };
    const getRoleLabel = (role: string) => {
        const roles: Record<string, string> = {
            administrateur: "Administrateur",
            responsable_commune: "Responsable commune",
            "responsable_financière": "Responsable financière",
            contribuable: "Contribuable",
            agent_collecteur: "Agent collecteur",
        };
    
        return roles[role] ?? role;
    };
    const filteredUsers = users.filter((user) => {
        const searchValue = search.toLowerCase().trim();
    
        return (
            user.nom.toLowerCase().includes(searchValue) ||
            user.prenom.toLowerCase().includes(searchValue) ||
            user.email.toLowerCase().includes(searchValue) ||
            getRoleLabel(user.role)
                .toLowerCase()
                .includes(searchValue)
        );
    });
    return (
        <div>
            <h2>Liste des utilisateurs</h2>
            <div>
                <input
                    type="text"
                    placeholder="🔎 Rechercher par nom, prénom, email ou rôle..."
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                />
            </div>
            {filteredUsers.length === 0 ? (
                <p>
                    {search
                        ? "Aucun utilisateur ne correspond à votre recherche."
                        : "Aucun utilisateur trouvé."}
                </p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    {filteredUsers.map((user) => (
                            <tr key={user.id}>
                                <td>{user.id}</td>
                                <td>{user.nom}</td>
                                <td>{user.prenom}</td>
                                <td>{user.email}</td>
                                <td>{getRoleLabel(user.role)}</td>
                                <td>{user.is_active ? "Actif" : "Désactivé"}</td>
                                <td>
                                    {new Date(
                                        user.created_at
                                    ).toLocaleDateString("fr-FR")}
                                </td>
                                <td>
                                    <button onClick={() => setSelectedUser(user)}>
                                        ✏️ Modifier
                                    </button>

                                    <button
                                        onClick={() => handleToggleStatus(user)}
                                    >
                                        {user.is_active ? "🚫 Désactiver" : "✅ Activer"}
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default UserList;