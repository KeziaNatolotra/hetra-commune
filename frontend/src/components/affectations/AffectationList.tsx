import { useEffect, useState } from "react";
import api from "../../api";

interface Affectation {
    id: number;
    taxe: { id: number; libelle: string } | null;
    contribuable: { id: number; nom: string; prenom: string | null } | null;
    contribuable_type: { id: number; nom: string } | null;
    zone_id: number | null;
    is_active: boolean;
}

function AffectationList() {
    const [affectations, setAffectations] = useState<Affectation[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        const fetchAffectations = async () => {
            try {
                const response = await api.get("/api/affectations");
                setAffectations(response.data);
            } catch (error: any) {
                console.error(error);
                setError("Impossible de récupérer les affectations.");
            } finally {
                setLoading(false);
            }
        };

        fetchAffectations();
    }, []);

    if (loading) {
        return <p>Chargement des affectations...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h2>Liste des affectations</h2>

            {affectations.length === 0 ? (
                <p>Aucune affectation trouvée.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Taxe</th>
                            <th>Contribuable</th>
                            <th>Type de contribuable</th>
                            <th>Zone</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        {affectations.map((a) => (
                            <tr key={a.id}>
                                <td>{a.taxe?.libelle ?? "-"}</td>
                                <td>
                                    {a.contribuable
                                        ? `${a.contribuable.nom} ${a.contribuable.prenom ?? ""}`
                                        : "-"}
                                </td>
                                <td>{a.contribuable_type?.nom ?? "-"}</td>
                                <td>{a.zone_id ?? "-"}</td>
                                <td>{a.is_active ? "Active" : "Inactive"}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default AffectationList;