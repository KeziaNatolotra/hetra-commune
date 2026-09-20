import { useEffect, useState } from "react";
import api from "../../api";

interface Recu {
  id: number;
  numero_recu: string;
  montant: string;
  date_emission: string;
  statut: string;
  paiement: {
    obligation: {
      contribuable: { nom: string; prenom: string | null };
      taxe: { libelle: string };
    };
  };
}

export default function RecuList() {
  const [recus, setRecus] = useState<Recu[]>([]);

  useEffect(() => {
    api.get("/api/recus").then((res) => setRecus(res.data));
  }, []);

  return (
    <div>
      <h3>Reçus</h3>
      {recus.length === 0 ? (
        <p>Aucun reçu trouvé.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>N° reçu</th>
              <th>Contribuable</th>
              <th>Taxe</th>
              <th>Montant</th>
              <th>Émis le</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            {recus.map((r) => (
              <tr key={r.id}>
                <td>{r.numero_recu}</td>
                <td>{r.paiement.obligation.contribuable.nom} {r.paiement.obligation.contribuable.prenom}</td>
                <td>{r.paiement.obligation.taxe.libelle}</td>
                <td>{r.montant} Ar</td>
                <td>{r.date_emission.slice(0, 10)}</td>
                <td>{r.statut}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}