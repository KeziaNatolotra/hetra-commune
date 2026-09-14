import { useEffect, useState } from "react";
import api from "../../api";

interface User {
    id: number;
    nom: string;
    prenom: string;
    email: string;
    role: string;
}

interface EditUserFormProps {
    user: User;
    onSuccess: () => void;
    onCancel: () => void;
}

function EditUserForm({
    user,
    onSuccess,
    onCancel,
}: EditUserFormProps) {
    const [formData, setFormData] = useState({
        nom: user.nom,
        prenom: user.prenom,
        email: user.email,
        password: "",
        password_confirmation: "",
        role: user.role,
    });

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setFormData({
            nom: user.nom,
            prenom: user.prenom,
            email: user.email,
            password: "",
            password_confirmation: "",
            role: user.role,
        });

        setMessage("");
        setError("");
    }, [user]);

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

        // Vérifier les mots de passe uniquement
        // si un nouveau mot de passe est renseigné.
        if (formData.password === "") {
            setError("Le nouveau mot de passe est obligatoire.");
            return;
        }
        
        if (formData.password_confirmation === "") {
            setError("La confirmation du mot de passe est obligatoire.");
            return;
        }
        
        if (
            formData.password !==
            formData.password_confirmation
        ) {
            setError("Les mots de passe ne correspondent pas.");
            return;
        }
        setLoading(true);

        try {
            // Données de base
            const data: {
                nom: string;
                prenom: string;
                email: string;
                role: string;
                password?: string;
                password_confirmation?: string;
            } = {
                nom: formData.nom,
                prenom: formData.prenom,
                email: formData.email,
                role: formData.role,
            };

            // Envoyer le mot de passe seulement
            // s'il doit réellement être modifié.
            if (formData.password !== "") {
                data.password = formData.password;
                data.password_confirmation =
                    formData.password_confirmation;
            }

            const response = await api.put(
                `/api/users/${user.id}`,
                data
            );

            console.log(response.data);

            setMessage(
                "Utilisateur modifié avec succès."
            );
            
            onSuccess();
        } catch (error: any) {
            console.error(error);

            if (error.response?.status === 422) {
                const errors = error.response.data?.errors;

                if (errors?.email) {
                    setError(errors.email[0]);
                } else if (errors?.password) {
                    setError(errors.password[0]);
                } else if (errors?.nom) {
                    setError(errors.nom[0]);
                } else if (errors?.prenom) {
                    setError(errors.prenom[0]);
                } else {
                    setError(
                        "Les informations saisies sont invalides."
                    );
                }
            } else {
                setError(
                    "Une erreur est survenue lors de la modification."
                );
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <h2>Modifier l'utilisateur</h2>

            {message && <p>{message}</p>}

            {error && <p>{error}</p>}

            <form onSubmit={handleSubmit}>

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
                        required
                    />
                </div>

                <div>
                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label>Nouveau mot de passe</label>

                    <input
                        type="password"
                        name="password"
                        value={formData.password}
                        onChange={handleChange}
                        placeholder="Saisir le nouveau mot de passe"
                        required
                    />
                </div>

                <div>
                    <label>
                        Confirmation du mot de passe
                    </label>

                    <input
                            type="password"
                            name="password_confirmation"
                            value={formData.password_confirmation}
                            onChange={handleChange}
                            placeholder="Confirmer le nouveau mot de passe"
                            required
                        />
                </div>

                <div>
                    <label>Rôle</label>

                    <select
                        name="role"
                        value={formData.role}
                        onChange={handleChange}
                    >
                        <option value="administrateur">
                            Administrateur
                        </option>

                        <option value="responsable_commune">
                            Responsable commune
                        </option>

                        <option value="responsable_financière">
                            Responsable financière
                        </option>

                        <option value="contribuable">
                            Contribuable
                        </option>

                        <option value="agent_collecteur">
                            Agent collecteur
                        </option>
                    </select>
                </div>

                <div>
                    <button
                        type="submit"
                        disabled={loading}
                    >
                        {loading
                            ? "Enregistrement..."
                            : "Enregistrer les modifications"}
                    </button>

                    <button
                        type="button"
                        onClick={onCancel}
                        disabled={loading}
                    >
                        Annuler
                    </button>
                </div>

            </form>
        </div>
    );
}

export default EditUserForm;