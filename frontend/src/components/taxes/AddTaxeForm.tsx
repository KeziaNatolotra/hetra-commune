import { useState } from "react";
import api from "../../api";

interface AddTaxeFormProps {
    onSuccess?: () => void;
    onCancel?: () => void;
}

const PERIODICITES = [
    "journaliere",
    "hebdomadaire",
    "mensuelle",
    "trimestrielle",
    "semestrielle",
    "annuelle",
    "ponctuelle",
    "personnalisee",
];

function AddTaxeForm({ onSuccess, onCancel }: AddTaxeFormProps) {
    const [formData, setFormData] = useState({
        code: "",
        libelle: "",
        description: "",
        montant: "",
        periodicite: "mensuelle",
        date_debut: "",
        date_fin: "",
    });

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>
    ) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();

        setMessage("");
        setError("");
        setLoading(true);

        try {
            const data = {
                code: formData.code,
                libelle: formData.libelle,
                description: formData.description || null,
                montant: Number(formData.montant),
                periodicite: formData.periodicite,
                date_debut: formData.date_debut,
                date_fin: formData.date_fin || null,
            };

            await api.post("/api/taxes", data);

            setMessage("Taxe créée avec succès.");

            setFormData({
                code: "",
                libelle: "",
                description: "",
                montant: "",
                periodicite: "mensuelle",
                date_debut: "",
                date_fin: "",
            });

            if (onSuccess) {
                setTimeout(() => {
                    onSuccess();
                }, 500);
            }
        } catch (error: any) {
            console.error(error);

            if (error.response?.status === 422) {
                const errors = error.response.data?.errors;

                if (errors?.code) {
                    setError(errors.code[0]);
                } else if (errors?.montant) {
                    setError(errors.montant[0]);
                } else if (errors?.date_debut) {
                    setError(errors.date_debut[0]);
                } else {
                    setError("Les informations saisies sont invalides.");
                }
            } else {
                setError("Une erreur est survenue lors de la création.");
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <h2>Ajouter une taxe</h2>

            {message && <p>{message}</p>}
            {error && <p>{error}</p>}

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Code</label>
                    <input
                        type="text"
                        name="code"
                        value={formData.code}
                        onChange={handleChange}
                        placeholder="Ex : TAX-MARCHE-JOUR"
                        required
                    />
                </div>

                <div>
                    <label>Libellé</label>
                    <input
                        type="text"
                        name="libelle"
                        value={formData.libelle}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Description</label>
                    <textarea
                        name="description"
                        value={formData.description}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Montant (Ar)</label>
                    <input
                        type="number"
                        name="montant"
                        value={formData.montant}
                        onChange={handleChange}
                        min="0"
                        required
                    />
                </div>

                <div>
                    <label>Périodicité</label>
                    <select
                        name="periodicite"
                        value={formData.periodicite}
                        onChange={handleChange}
                    >
                        {PERIODICITES.map((p) => (
                            <option key={p} value={p}>
                                {p}
                            </option>
                        ))}
                    </select>
                </div>

                <div>
                    <label>Date de début</label>
                    <input
                        type="date"
                        name="date_debut"
                        value={formData.date_debut}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Date de fin (optionnel)</label>
                    <input
                        type="date"
                        name="date_fin"
                        value={formData.date_fin}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <button type="submit" disabled={loading}>
                        {loading ? "Enregistrement..." : "Ajouter la taxe"}
                    </button>

                    {onCancel && (
                        <button type="button" onClick={onCancel} disabled={loading}>
                            Annuler
                        </button>
                    )}
                </div>
            </form>
        </div>
    );
}

export default AddTaxeForm;