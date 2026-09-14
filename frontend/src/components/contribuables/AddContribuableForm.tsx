import { useEffect, useState } from "react";
import api from "../../api";

interface AddContribuableFormProps {
    onSuccess?: () => void;
    onCancel?: () => void;
}
interface ContribuableType {
    id: number;
    nom: string;
}
function AddContribuableForm({
    onSuccess,
    onCancel,
}: AddContribuableFormProps) {
    const [formData, setFormData] = useState({
        reference: "",
        nom: "",
        prenom: "",
        raison_sociale: "",
        cin: "",
        nif: "",
        stat: "",
        telephone: "",
        adresse: "",
        activite: "",
        emplacement: "",
        date_inscription: "",
        statut: "actif",
        contribuable_type_id: "",
        fokontany_id: "",
        zone_id: "",
        marche_id: "",
    });

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);
    const [contribuableTypes, setContribuableTypes] = useState<ContribuableType[]>([]);
    const [loadingTypes, setLoadingTypes] = useState(true);
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
                reference: formData.reference,
                nom: formData.nom,
                prenom: formData.prenom || null,
                raison_sociale: formData.raison_sociale || null,
                cin: formData.cin || null,
                nif: formData.nif || null,
                stat: formData.stat || null,
                telephone: formData.telephone,
                adresse: formData.adresse,
                activite: formData.activite || null,
                emplacement: formData.emplacement || null,
                date_inscription: formData.date_inscription,
                statut: formData.statut,
                contribuable_type_id: Number(formData.contribuable_type_id),
                fokontany_id: formData.fokontany_id
                    ? Number(formData.fokontany_id)
                    : null,
                zone_id: formData.zone_id
                    ? Number(formData.zone_id)
                    : null,
                marche_id: formData.marche_id
                    ? Number(formData.marche_id)
                    : null,
            };

            const response = await api.post(
                "/api/contribuables",
                data
            );

            console.log(response.data);

            setMessage("Contribuable créé avec succès.");

            setFormData({
                reference: "",
                nom: "",
                prenom: "",
                raison_sociale: "",
                cin: "",
                nif: "",
                stat: "",
                telephone: "",
                adresse: "",
                activite: "",
                emplacement: "",
                date_inscription: "",
                statut: "actif",
                contribuable_type_id: "",
                fokontany_id: "",
                zone_id: "",
                marche_id: "",
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

                if (errors?.reference) {
                    setError(errors.reference[0]);
                } else if (errors?.nom) {
                    setError(errors.nom[0]);
                } else if (errors?.telephone) {
                    setError(errors.telephone[0]);
                } else if (errors?.adresse) {
                    setError(errors.adresse[0]);
                } else if (errors?.date_inscription) {
                    setError(errors.date_inscription[0]);
                } else if (errors?.contribuable_type_id) {
                    setError(errors.contribuable_type_id[0]);
                } else {
                    setError(
                        "Les informations saisies sont invalides."
                    );
                }
            } else {
                setError(
                    "Une erreur est survenue lors de la création."
                );
            }
        } finally {
            setLoading(false);
        }
    };
    useEffect(() => {
        const fetchContribuableTypes = async () => {
            try {
                const response = await api.get("/api/contribuable-types");
    
                setContribuableTypes(response.data.contribuable_types);
            } catch (error) {
                console.error(
                    "Erreur lors du chargement des types de contribuables :",
                    error
                );
    
                setError(
                    "Impossible de récupérer les types de contribuables."
                );
            } finally {
                setLoadingTypes(false);
            }
        };
    
        fetchContribuableTypes();
    }, []);
    return (
        <div>
            <h2>Ajouter un contribuable</h2>

            {message && <p>{message}</p>}

            {error && <p>{error}</p>}

            <form onSubmit={handleSubmit}>

                <div>
                    <label>Référence</label>
                    <input
                        type="text"
                        name="reference"
                        value={formData.reference}
                        onChange={handleChange}
                        placeholder="Ex : HTK-C-000125"
                        required
                    />
                </div>

                <div>
                    <label>Nom</label>
                    <input
                        type="text"
                        name="nom"
                        value={formData.nom}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Prénom</label>
                    <input
                        type="text"
                        name="prenom"
                        value={formData.prenom}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Raison sociale</label>
                    <input
                        type="text"
                        name="raison_sociale"
                        value={formData.raison_sociale}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>CIN</label>
                    <input
                        type="text"
                        name="cin"
                        value={formData.cin}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>NIF</label>
                    <input
                        type="text"
                        name="nif"
                        value={formData.nif}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>STAT</label>
                    <input
                        type="text"
                        name="stat"
                        value={formData.stat}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Téléphone</label>
                    <input
                        type="text"
                        name="telephone"
                        value={formData.telephone}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Adresse</label>
                    <textarea
                        name="adresse"
                        value={formData.adresse}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Activité</label>
                    <input
                        type="text"
                        name="activite"
                        value={formData.activite}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Emplacement</label>
                    <input
                        type="text"
                        name="emplacement"
                        value={formData.emplacement}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Date d'inscription</label>
                    <input
                        type="date"
                        name="date_inscription"
                        value={formData.date_inscription}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Statut</label>

                    <select
                        name="statut"
                        value={formData.statut}
                        onChange={handleChange}
                    >
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>

                <div>
                    <label>Type de contribuable</label>

                    <select
                        name="contribuable_type_id"
                        value={formData.contribuable_type_id}
                        onChange={handleChange}
                        required
                        disabled={loadingTypes}
                    >
                        <option value="">
                            {loadingTypes
                                ? "Chargement des types..."
                                : "Sélectionner un type"}
                        </option>

                        {contribuableTypes.map((type) => (
                            <option
                                key={type.id}
                                value={type.id}
                            >
                                {type.nom}
                            </option>
                        ))}
                    </select>
                </div>
                <div>
                    <label>Fokontany ID</label>

                    <input
                        type="number"
                        name="fokontany_id"
                        value={formData.fokontany_id}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Zone ID</label>

                    <input
                        type="number"
                        name="zone_id"
                        value={formData.zone_id}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Marché ID</label>

                    <input
                        type="number"
                        name="marche_id"
                        value={formData.marche_id}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <button
                        type="submit"
                        disabled={loading}
                    >
                        {loading
                            ? "Enregistrement..."
                            : "Ajouter le contribuable"}
                    </button>

                    {onCancel && (
                        <button
                            type="button"
                            onClick={onCancel}
                            disabled={loading}
                        >
                            Annuler
                        </button>
                    )}
                </div>

            </form>
        </div>
    );
}

export default AddContribuableForm;