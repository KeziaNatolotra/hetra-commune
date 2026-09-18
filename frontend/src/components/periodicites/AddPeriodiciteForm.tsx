import { useState } from "react";
import api from "../../api";

interface AddPeriodiciteFormProps {
    onSuccess?: () => void;
    onCancel?: () => void;
}

function AddPeriodiciteForm({ onSuccess, onCancel }: AddPeriodiciteFormProps) {
    const [formData, setFormData] = useState({
        code: "",
        libelle: "",
        description: "",
        duree_jours: "",
    });

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>
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
                duree_jours: formData.duree_jours
                    ? Number(formData.duree_jours)
                    : null,
            };

            await api.post("/api/periodicites", data);

            setMessage("Périodicité créée avec succès.");

            setFormData({
                code: "",
                libelle: "",
                description: "",
                duree_jours: "",
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
            <h2>Ajouter une périodicité</h2>

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
                        placeholder="Ex : bimensuelle"
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
                    <label>Durée (jours, optionnel)</label>
                    <input
                        type="number"
                        name="duree_jours"
                        value={formData.duree_jours}
                        onChange={handleChange}
                        min="1"
                    />
                </div>

                <div>
                    <button type="submit" disabled={loading}>
                        {loading ? "Enregistrement..." : "Ajouter la périodicité"}
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

export default AddPeriodiciteForm;