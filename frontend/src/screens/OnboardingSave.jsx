import OnboardingTemplate from "../components/OnboardingTemplate.jsx";

const OnboardingSave = () => (
  <OnboardingTemplate
    title="Save Your Favorite Places"
    subtitle="Find the best prices across Uber, Bolt, and Yango in seconds."
    nextPath="/onboarding/insights"
    hero="favorites"
    step={2}
    activeDot={2}
    nextLabel="Next ->"
    showSkip
  />
);

export default OnboardingSave;
