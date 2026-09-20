import { useEffect, useState } from "react";
import api from "../../api";

interface Paiement {
  id: number;
  montant: string;
  statut: string;
  obligation: {
    contribuable: { nom: string; prenom: string | null };
    taxe: { libelle: string };
  };
  transaction: {
    reference_externe: string;
    statut: string;
  };
}

export default function PaiementList() {
  const [paiements, setPaiements] = useState<Paiement[]>([]);

  const fetchPaiements = () => {
    api.get("/api/paiements").then((res) => setPaiements(res.data));
  };

  useEffect(() => {
    fetchPaiements();
  }, []);

  const simuler = async (referenceExterne: string, resultat: "succes" | "echec") => {
    await api.patch(`/api/mock-mobile-money/${referenceExterne}/callback`, { resultat });
    fetchPaiements();
  };

  return (
    <div>
      <h3>Paiements</h3>
      {paiements.length === 0 ? (
        <p>Aucun paiement trouvé.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>Contribuable</th>
              <th>Taxe</th>
              <th>Montant</th>
              <th>Référence</th>
              <th>Statut</th>
              <th>Simuler (test)</th>
            </tr>
          </thead>
          <tbody>
            {paiements.map((p) => (
              <tr key={p.id}>
                <td>{p.obligation.contribuable.nom} {p.obligation.contribuable.prenom}</td>
                <td>{p.obligation.taxe.libelle}</td>
                <td>{p.montant} Ar</td>
                <td>{p.transaction.reference_externe}</td>
                <td>{p.transaction.statut}</td>
                <td>
                  {p.transaction.statut === "pending" && (
                    <>
                      <button onClick={() => simuler(p.transaction.reference_externe, "succes")}>
                        ✅ Succès
                      </button>{" "}
                      <button onClick={() => simuler(p.transaction.reference_externe, "echec")}>
                        ❌ Échec
                      </button>
                    </>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}