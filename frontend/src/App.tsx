import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";

import Login from "./pages/Login";
import Dashboard from "./pages/DashboardAdmin";
import FinanceDashboard from "./pages/dashboards/FinanceDashboard";
import CommuneDashboard from "./pages/dashboards/CommuneDashboard";
function App() {
    return (
        <BrowserRouter>
            <Routes>

                {/* Connexion */}
                <Route path="/login" element={<Login />} />

                {/* Dashboard Administrateur */}
                <Route path="/dashboard" element={<Dashboard />} />

                {/* Dashboard Responsable financière */}
                <Route
                    path="/dashboard/finance"
                    element={<FinanceDashboard />}
                />
                <Route
                    path="/dashboard/commune"
                    element={<CommuneDashboard />}
                />

                {/* Route par défaut */}
                <Route
                    path="*"
                    element={<Navigate to="/login" replace />}
                />

            </Routes>
        </BrowserRouter>
    );
}

export default App;