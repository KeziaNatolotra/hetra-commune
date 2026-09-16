import { useState } from "react";
import api from "../../api";

interface AddUserFormProps {
    onSuccess: () => void;
    onCancel: () => void;
}

function AddUserForm({
    onSuccess,
    onCancel,
}: AddUserFormProps) {
    const [formData, setFormData] = useState({
        nom: "",
        prenom: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: "contribuable",
    });

    const [message, setMessage] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

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

        // Vérification des mots de passe
        if (formData.password !== formData.password_confirmation) {
            setError("Les mots de passe ne correspondent pas.");
            return;
        }

        setLoading(true);

        try {
            const response = await api.post(
                "/api/users",
                formData
            );

            console.log(response.data);

            setMessage("Utilisateur créé avec succès.");

            setFormData({
                nom: "",
                prenom: "",
                email: "",
                password: "",
                password_confirmation: "",
                role: "contribuable",
            });

            // Retour à la liste après création
            setTimeout(() => {
                onSuccess();
            }, 500);

        } catch (error: any) {
            console.error(error);

            if (error.response?.status === 422) {
                const errors = error.response.data?.errors;

                if (errors?.email) {
                    setError(errors.email[0]);
                } else if (errors?.password) {
                    setError(errors.password[0]);
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

    return (
        <div>
            <h2>Ajouter un utilisateur</h2>

            {message && (
                <p>{message}</p>
            )}

            {error && (
                <p>{error}</p>
            )}

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
                    <label>Mot de passe</label>

                    <input
                        type="password"
                        name="password"
                        value={formData.password}
                        onChange={handleChange}
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
    			<option value="admin">
        		     Administrateur
    			</option>

    			<option value="responsable_communal">
        		     Responsable commune
    			</option>

    			<option value="responsable_financiere">
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
                            ? "Création..."
                            : "Ajouter l'utilisateur"}
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

export default AddUserForm;