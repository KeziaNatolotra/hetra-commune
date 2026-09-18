import { useEffect, useState } from "react";
import api from "../../api";

interface Periodicite {
    id: number;
    code: string;
    libelle: string;
    description: string | null;
    duree_jours: number | null;
    is_active: boolean;
}

function PeriodiciteList() {
    const [periodicites, setPeriodicites] = useState<Periodicite[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        const fetchPeriodicites = async () => {
            try {
                const response = await api.get("/api/periodicites");
                setPeriodicites(response.data);
            } catch (error: any) {
                console.error(error);
                setError("Impossible de récupérer les périodicités.");
            } finally {
                setLoading(false);
            }
        };

        fetchPeriodicites();
    }, []);

    if (loading) {
        return <p>Chargement des périodicités...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h2>Liste des périodicités</h2>

            {periodicites.length === 0 ? (
                <p>Aucune périodicité trouvée.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Libellé</th>
                            <th>Durée (jours)</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        {periodicites.map((p) => (
                            <tr key={p.id}>
                                <td>{p.code}</td>
                                <td>{p.libelle}</td>
                                <td>{p.duree_jours ?? "-"}</td>
                                <td>{p.is_active ? "Active" : "Inactive"}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default PeriodiciteList;