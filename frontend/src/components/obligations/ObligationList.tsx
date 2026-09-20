import { useEffect, useState } from "react";
import api from "../../api";

interface Obligation {
  id: number;
  contribuable: { nom: string; prenom: string | null };
  taxe: { libelle: string };
  date_echeance: string;
  montant_du: string;
  montant_paye: string;
  statut: string;
}

interface Props {
  readOnly?: boolean;
}

export default function ObligationList({ readOnly = false }: Props) {
  const [obligations, setObligations] = useState<Obligation[]>([]);
  const [message, setMessage] = useState<string | null>(null);

  const fetchObligations = () => {
    api.get("/api/obligations").then((res) => setObligations(res.data));
  };

  useEffect(() => {
    fetchObligations();
  }, []);

  const payer = async (obligationId: number) => {
    setMessage(null);
    try {
      await api.post("/api/paiements", { obligation_id: obligationId });
      setMessage("Paiement initié — va dans l'onglet Paiements pour simuler la confirmation.");
      fetchObligations();
    } catch (err: any) {
      setMessage(err.response?.data?.message ?? "Erreur lors de l'initiation du paiement.");
    }
  };

  return (
    <div>
      <h3>Liste des obligations</h3>
      {message && <p style={{ color: "orange" }}>{message}</p>}

      {obligations.length === 0 ? (
        <p>Aucune obligation trouvée.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>Contribuable</th>
              <th>Taxe</th>
              <th>Échéance</th>
              <th>Montant dû</th>
              <th>Payé</th>
              <th>Statut</th>
              {!readOnly && <th>Action</th>}
            </tr>
          </thead>
          <tbody>
            {obligations.map((o) => (
              <tr key={o.id}>
                <td>{o.contribuable.nom} {o.contribuable.prenom}</td>
                <td>{o.taxe.libelle}</td>
                <td>{o.date_echeance.slice(0, 10)}</td>
                <td>{o.montant_du} Ar</td>
                <td>{o.montant_paye} Ar</td>
                <td>{o.statut}</td>
                {!readOnly && (
                  <td>
                    {(o.statut === "a_payer" || o.statut === "partiellement_paye") && (
                      <button onClick={() => payer(o.id)}>Payer</button>
                    )}
                  </td>
                )}
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}