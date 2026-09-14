import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api";
import AddUserForm from "../components/users/AddUserForm";
import UserList from "../components/users/UserList";
import ContribuableList from "../components/contribuables/ContribuableList";
import AddContribuableForm from "../components/contribuables/AddContribuableForm";

function Dashboard() {
  const navigate = useNavigate();

  const [activePage, setActivePage] = useState("dashboard");
  const [permissions, setPermissions] = useState<string[]>([]);

  useEffect(() => {
    const fetchUserPermissions = async () => {
      try {
        const response = await api.get("/api/user");

        setPermissions(response.data.permissions || []);
      } catch (error) {
        console.error(
          "Erreur lors de la récupération des permissions :",
          error
        );
      }
    };

    fetchUserPermissions();
  }, []);

  const hasPermission = (permission: string) => {
    return permissions.includes(permission);
  };

  const handleLogout = async () => {
    try {
      await api.post("/api/logout");

      console.log("Déconnexion réussie");

      navigate("/login", { replace: true });
    } catch (error) {
      console.error("Erreur lors de la déconnexion :", error);
    }
  };

  return (
    <div>
      <header>
        <h1>Dashboard Admin</h1>

        <button onClick={handleLogout}>
          Déconnexion
        </button>
      </header>

      <nav>
        <button onClick={() => setActivePage("dashboard")}>
          🏠 Tableau de bord
        </button>

        {hasPermission("users.view") && (
          <button onClick={() => setActivePage("user-list")}>
            👥 Utilisateurs → Liste
          </button>
        )}

        {hasPermission("users.create") && (
          <button onClick={() => setActivePage("add-user")}>
            👥 Utilisateurs → Ajouter
          </button>
        )}

        {hasPermission("contribuables.view") && (
          <button onClick={() => setActivePage("contribuable-list")}>
            👤 Contribuables → Liste
          </button>
        )}

        {hasPermission("contribuables.create") && (
          <button onClick={() => setActivePage("contribuable-add")}>
            👤 Contribuables → Ajouter
          </button>
        )}
      </nav>

      <main>
        {activePage === "dashboard" && (
          <div>
            <h2>Tableau de bord</h2>

            <p>
              Bienvenue dans le tableau de bord administrateur.
            </p>
          </div>
        )}

        {activePage === "add-user" && hasPermission("users.create") && (
          <AddUserForm
            onSuccess={() => setActivePage("user-list")}
            onCancel={() => setActivePage("dashboard")}
          />
        )}

        {activePage === "user-list" && hasPermission("users.view") && (
          <UserList />
        )}

        {activePage === "contribuable-list" &&
          hasPermission("contribuables.view") && (
            <ContribuableList />
          )}

        {activePage === "contribuable-add" &&
          hasPermission("contribuables.create") && (
            <AddContribuableForm
              onSuccess={() => setActivePage("contribuable-list")}
              onCancel={() => setActivePage("dashboard")}
            />
          )}
      </main>
    </div>
  );
}

export default Dashboard;