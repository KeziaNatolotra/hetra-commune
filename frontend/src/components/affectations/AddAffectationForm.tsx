import { useEffect, useState } from "react";
import api from "../../api";

interface AddAffectationFormProps {
    onSuccess?: () => void;
    onCancel?: () => void;
}

interface Taxe {
    id: number;
    libelle: string;
}

interface ContribuableType {
    id: number;
    nom: string;
}

function AddAffectationForm({ onSuccess, onCancel }: AddAffectationFormProps) {
    const [formData, setFormData] = useState({
        taxe_id: "",
        contribuable_id: "",
        contribuable_type_id: "",
        zone_id: "",
    });

    const [taxes, setTaxes] = useState<Taxe[]>([]);
    const [types, setTypes] = useState<ContribuableType[]>([]);
    const [loadingOptions, setLoadingOptions] = useState(true);

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const fetchOptions = async () => {
            try {
                const [taxesRes, typesRes] = await Promise.all([
                    api.get("/api/taxes"),
                    api.get("/api/contribuable-types"),
                ]);

                setTaxes(taxesRes.data);
                setTypes(typesRes.data.contribuable_types);
            } catch (error) {
                console.error(
                    "Erreur lors du chargement des options :",
                    error
                );
            } finally {
                setLoadingOptions(false);
            }
        };

        fetchOptions();
    }, []);

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
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
                taxe_id: Number(formData.taxe_id),
                contribuable_id: formData.contribuable_id
                    ? Number(formData.contribuable_id)
                    : null,
                contribuable_type_id: formData.contribuable_type_id
                    ? Number(formData.contribuable_type_id)
                    : null,
                zone_id: formData.zone_id ? Number(formData.zone_id) : null,
            };

            await api.post("/api/affectations", data);

            setMessage("Affectation créée avec succès.");

            setFormData({
                taxe_id: "",
                contribuable_id: "",
                contribuable_type_id: "",
                zone_id: "",
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

                if (errors?.cible) {
                    setError(errors.cible[0]);
                } else if (errors?.taxe_id) {
                    setError(errors.taxe_id[0]);
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
            <h2>Ajouter une affectation</h2>

            {message && <p>{message}</p>}
            {error && <p>{error}</p>}

            <p>
                Précisez au moins une cible : un contribuable, un type de
                contribuable, ou une zone.
            </p>

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Taxe</label>
                    <select
                        name="taxe_id"
                        value={formData.taxe_id}
                        onChange={handleChange}
                        required
                        disabled={loadingOptions}
                    >
                        <option value="">
                            {loadingOptions
                                ? "Chargement..."
                                : "Sélectionner une taxe"}
                        </option>

                        {taxes.map((t) => (
                            <option key={t.id} value={t.id}>
                                {t.libelle}
                            </option>
                        ))}
                    </select>
                </div>

                <div>
                    <label>Contribuable ID (optionnel)</label>
                    <input
                        type="number"
                        name="contribuable_id"
                        value={formData.contribuable_id}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Type de contribuable (optionnel)</label>
                    <select
                        name="contribuable_type_id"
                        value={formData.contribuable_type_id}
                        onChange={handleChange}
                        disabled={loadingOptions}
                    >
                        <option value="">Aucun</option>

                        {types.map((t) => (
                            <option key={t.id} value={t.id}>
                                {t.nom}
                            </option>
                        ))}
                    </select>
                </div>

                <div>
                    <label>Zone ID (optionnel)</label>
                    <input
                        type="number"
                        name="zone_id"
                        value={formData.zone_id}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <button type="submit" disabled={loading}>
                        {loading ? "Enregistrement..." : "Ajouter l'affectation"}
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

export default AddAffectationForm;