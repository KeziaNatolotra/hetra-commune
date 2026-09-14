import { useEffect, useState } from "react";
import api from "../../api";

interface Contribuable {
    id: number;
    reference: string;
    nom: string;
    prenom: string | null;
    raison_sociale: string | null;
    cin: string | null;
    nif: string | null;
    stat: string | null;
    telephone: string;
    adresse: string;
    activite: string | null;
    emplacement: string | null;
    date_inscription: string;
    statut: "actif" | "inactif";
    created_at: string;
}

function ContribuableList() {
    const [contribuables, setContribuables] = useState<Contribuable[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        const fetchContribuables = async () => {
            try {
                const response = await api.get("/api/contribuables");

                setContribuables(response.data.contribuables);
            } catch (error: any) {
                console.error(error);
                setError("Impossible de récupérer les contribuables.");
            } finally {
                setLoading(false);
            }
        };

        fetchContribuables();
    }, []);

    if (loading) {
        return <p>Chargement des contribuables...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h2>Liste des contribuables</h2>

            {contribuables.length === 0 ? (
                <p>Aucun contribuable trouvé.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Raison sociale</th>
                            <th>CIN</th>
                            <th>NIF</th>
                            <th>Téléphone</th>
                            <th>Activité</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                        </tr>
                    </thead>

                    <tbody>
                        {contribuables.map((contribuable) => (
                            <tr key={contribuable.id}>
                                <td>{contribuable.reference}</td>
                                <td>{contribuable.nom}</td>
                                <td>{contribuable.prenom ?? "-"}</td>
                                <td>{contribuable.raison_sociale ?? "-"}</td>
                                <td>{contribuable.cin ?? "-"}</td>
                                <td>{contribuable.nif ?? "-"}</td>
                                <td>{contribuable.telephone}</td>
                                <td>{contribuable.activite ?? "-"}</td>
                                <td>
                                    {contribuable.statut === "actif"
                                        ? "Actif"
                                        : "Inactif"}
                                </td>
                                <td>
                                    {new Date(
                                        contribuable.date_inscription
                                    ).toLocaleDateString("fr-FR")}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default ContribuableList;