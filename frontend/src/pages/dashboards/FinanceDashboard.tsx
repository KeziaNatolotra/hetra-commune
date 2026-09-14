import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../api";

function FinanceDashboard() {
    const [activePage, setActivePage] = useState("dashboard");
    const navigate = useNavigate();

    const menuItems = [
        { id: "dashboard", label: "🏠 Tableau de bord" },
        { id: "contribuables", label: "👤 Contribuables" },
        { id: "taxes", label: "💰 Taxes & Redevances" },
        { id: "periodicites", label: "📅 Périodicités" },
        { id: "affectations", label: "🔗 Affectations" },
        { id: "obligations", label: "📋 Obligations" },
        { id: "paiements", label: "💳 Paiements" },
        { id: "transactions", label: "🔐 Transactions" },
        { id: "recus", label: "🧾 Reçus" },
        { id: "qr-codes", label: "🔲 QR Codes" },
        { id: "controles", label: "🔎 Contrôles" },
        { id: "rapports", label: "📊 Rapports" },
        { id: "notifications", label: "🔔 Notifications" },
        { id: "audit", label: "📝 Audit" },
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
                <h1>Dashboard Responsable financière</h1>

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
                            de la responsable financière.
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

export default FinanceDashboard;