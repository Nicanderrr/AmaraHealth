import { BrowserRouter, Routes, Route, Navigate, useLocation } from "react-router-dom";
import PageShell from "./components/PageShell.jsx";
import Splash from "./screens/Splash.jsx";
import OnboardingCompare from "./screens/OnboardingCompare.jsx";
import OnboardingSave from "./screens/OnboardingSave.jsx";
import OnboardingDecisions from "./screens/OnboardingDecisions.jsx";
import Login from "./screens/Login.jsx";
import Signup from "./screens/Signup.jsx";
import Loading from "./screens/Loading.jsx";
import Home from "./screens/Home.jsx";
import RideMatch from "./screens/RideMatch.jsx";
import RideDetails from "./screens/RideDetails.jsx";
import Profile from "./screens/Profile.jsx";
import EditProfile from "./screens/EditProfile.jsx";
import EditLocation from "./screens/EditLocation.jsx";
import Insights from "./screens/Insights.jsx";
import History from "./screens/History.jsx";
import Explore from "./screens/Explore.jsx";

const AppRoutes = () => {
  const location = useLocation();
  const wrap = (node) => <PageShell key={location.pathname}>{node}</PageShell>;

  return (
    <Routes location={location} key={location.pathname}>
      <Route path="/" element={wrap(<Splash />)} />
      <Route path="/onboarding/compare" element={wrap(<OnboardingCompare />)} />
      <Route path="/onboarding/favorites" element={wrap(<OnboardingSave />)} />
      <Route path="/onboarding/insights" element={wrap(<OnboardingDecisions />)} />
      <Route path="/login" element={wrap(<Login />)} />
      <Route path="/signup" element={wrap(<Signup />)} />
      <Route path="/loading" element={wrap(<Loading />)} />
      <Route path="/home" element={wrap(<Home />)} />
      <Route path="/ride-match" element={wrap(<RideMatch />)} />
      <Route path="/ride-details" element={wrap(<RideDetails />)} />
      <Route path="/profile" element={wrap(<Profile />)} />
      <Route path="/edit-profile" element={wrap(<EditProfile />)} />
      <Route path="/edit-location" element={wrap(<EditLocation />)} />
      <Route path="/insights" element={wrap(<Insights />)} />
      <Route path="/history" element={wrap(<History />)} />
      <Route path="/explore" element={wrap(<Explore />)} />
      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
};

const App = () => (
  <BrowserRouter>
    <AppRoutes />
  </BrowserRouter>
);

export default App;
