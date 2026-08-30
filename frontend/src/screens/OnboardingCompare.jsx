import OnboardingTemplate from "../components/OnboardingTemplate.jsx";

const OnboardingCompare = () => (
  <OnboardingTemplate
    title="Compare & Save"
    subtitle="Find the best prices across Uber, Bolt, and Yango in seconds."
    nextPath="/onboarding/favorites"
    hero="compare"
    step={1}
    activeDot={2}
    nextLabel="Next ->"
    showSkip
  />
);

export default OnboardingCompare;
