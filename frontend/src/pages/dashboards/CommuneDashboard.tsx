import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../api";

function CommuneDashboard() {
    const [activePage, setActivePage] = useState("dashboard");
    const navigate = useNavigate();

    const menuItems = [
        { id: "dashboard", label: "🏠 Tableau de bord" },
        { id: "contribuables", label: "👤 Contribuables" },
        { id: "taxes", label: "💰 Taxes & Redevances" },
        { id: "obligations", label: "📋 Obligations" },
        { id: "agents", label: "👨‍💼 Agents" },
        { id: "zones", label: "📍 Zones / Fokontany / Marchés" },
        { id: "controles", label: "🔎 Contrôles" },
        { id: "rapports", label: "📊 Rapports" },
        { id: "notifications", label: "🔔 Notifications" },
    ];

    const getPageTitle = () => {
        const page = menuItems.find((item) => item.id === activePage);
        return page?.label ?? "Tableau de bord";
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
                <h1>Dashboard Responsable commune</h1>

                <button onClick={handleLogout}>
                    Déconnexion
                </button>
            </header>

            <nav>
                {menuItems.map((item) => (
                    <button
                        key={item.id}
                        onClick={() => setActivePage(item.id)}
                    >
                        {item.label}
                    </button>
                ))}
            </nav>

            <main>
                <h2>{getPageTitle()}</h2>

                {activePage === "dashboard" && (
                    <div>
                        <p>
                            Bienvenue dans le tableau de bord
                            du responsable commune.
                        </p>
                    </div>
                )}

                {activePage !== "dashboard" && (
                    <div>
                        <p>
                            Module « {getPageTitle()} ».
                        </p>

                        <p>
                            Cette fonctionnalité sera développée
                            dans une prochaine étape.
                        </p>
                    </div>
                )}
            </main>
        </div>
    );
}

export default CommuneDashboard;