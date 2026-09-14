import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api";

function Login() {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const [loading, setLoading] = useState(false);

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();

    setMessage("");
    setLoading(true);

    try {
      // 1. Récupération du cookie CSRF
      await api.get("/sanctum/csrf-cookie");

      // 2. Connexion
      const response = await api.post("/api/login", {
        email,
        password,
      });

      const user = response.data.user;

      console.log("Utilisateur connecté :", user);

      // 3. Redirection selon le rôle
switch (user.role) {
  case "admin":
    navigate("/dashboard", { replace: true });
    break;

  case "responsable_communal":
    navigate("/dashboard/commune", { replace: true });
    break;

  case "responsable_financiere":
    navigate("/dashboard/finance", { replace: true });
    break;

  case "contribuable":
    navigate("/dashboard/contribuable", { replace: true });
    break;

  case "agent_collecteur":
    navigate("/dashboard/collecteur", { replace: true });
    break;

  default:
    setMessage("Rôle utilisateur non reconnu.");
}
    } catch (error: any) {
      console.error("Erreur de connexion :", error);

      if (error.response?.status === 422) {
        setMessage("Email ou mot de passe incorrect.");
      } else {
        setMessage("Une erreur est survenue lors de la connexion.");
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h1>Connexion</h1>

      <form onSubmit={handleLogin}>
        <div>
          <label>Email</label>

          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
        </div>

        <div>
          <label>Mot de passe</label>

          <input
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </div>

        <button type="submit" disabled={loading}>
          {loading ? "Connexion..." : "Se connecter"}
        </button>
      </form>

      {message && <p>{message}</p>}
    </div>
  );
}

export default Login;