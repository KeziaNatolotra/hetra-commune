import { useState } from "react";
import api from "../../api";

interface Props {
  onSuccess: () => void;
}

export default function AddObligationForm({ onSuccess }: Props) {
  const [contribuableId, setContribuableId] = useState("");
  const [taxeId, setTaxeId] = useState("");
  const [periodeDebut, setPeriodeDebut] = useState("");
  const [periodeFin, setPeriodeFin] = useState("");
  const [dateEcheance, setDateEcheance] = useState("");
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    try {
      await api.post("/api/obligations", {
        contribuable_id: Number(contribuableId),
        taxe_id: Number(taxeId),
        periode_debut: periodeDebut,
        periode_fin: periodeFin || null,
        date_echeance: dateEcheance,
      });

      setContribuableId("");
      setTaxeId("");
      setPeriodeDebut("");
      setPeriodeFin("");
      setDateEcheance("");
      onSuccess();
    } catch (err: any) {
      setError(
        err.response?.data?.message ?? "Les informations saisies sont invalides."
      );
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h3>Ajouter une obligation</h3>
      {error && <p style={{ color: "salmon" }}>{error}</p>}

      <label>
        Contribuable ID
        <input value={contribuableId} onChange={(e) => setContribuableId(e.target.value)} required />
      </label>

      <label>
        Taxe ID
        <input value={taxeId} onChange={(e) => setTaxeId(e.target.value)} required />
      </label>

      <label>
        Période début
        <input type="date" value={periodeDebut} onChange={(e) => setPeriodeDebut(e.target.value)} required />
      </label>

      <label>
        Période fin (optionnel)
        <input type="date" value={periodeFin} onChange={(e) => setPeriodeFin(e.target.value)} />
      </label>

      <label>
        Date d'échéance
        <input type="date" value={dateEcheance} onChange={(e) => setDateEcheance(e.target.value)} required />
      </label>

      <button type="submit">Ajouter l'obligation</button>
    </form>
  );
}