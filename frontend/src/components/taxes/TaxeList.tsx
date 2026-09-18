import { useEffect, useState } from "react";
import api from "../../api";

interface Taxe {
    id: number;
    code: string;
    libelle: string;
    description: string | null;
    montant: string;
    periodicite: string;
    date_debut: string;
    date_fin: string | null;
    is_active: boolean;
}

function TaxeList() {
    const [taxes, setTaxes] = useState<Taxe[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        const fetchTaxes = async () => {
            try {
                const response = await api.get("/api/taxes");

                setTaxes(response.data);
            } catch (error: any) {
                console.error(error);
                setError("Impossible de récupérer les taxes.");
            } finally {
                setLoading(false);
            }
        };

        fetchTaxes();
    }, []);

    if (loading) {
        return <p>Chargement des taxes...</p>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h2>Liste des taxes</h2>

            {taxes.length === 0 ? (
                <p>Aucune taxe trouvée.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                            <th>Périodicité</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        {taxes.map((taxe) => (
                            <tr key={taxe.id}>
                                <td>{taxe.code}</td>
                                <td>{taxe.libelle}</td>
                                <td>{taxe.montant} Ar</td>
                                <td>{taxe.periodicite}</td>
                                <td>
                                    {new Date(
                                        taxe.date_debut
                                    ).toLocaleDateString("fr-FR")}
                                </td>
                                <td>
                                    {taxe.date_fin
                                        ? new Date(
                                              taxe.date_fin
                                          ).toLocaleDateString("fr-FR")
                                        : "-"}
                                </td>
                                <td>
                                    {taxe.is_active ? "Active" : "Inactive"}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default TaxeList;