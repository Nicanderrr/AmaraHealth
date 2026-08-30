import OnboardingTemplate from "../components/OnboardingTemplate.jsx";

const OnboardingDecisions = () => (
  <OnboardingTemplate
    title="Make Smarter Travel Decisions"
    subtitle="Find the best prices across Uber, Bolt, and Yango in seconds."
    nextPath="/login"
    hero="insights"
    step={3}
    activeDot={2}
    nextLabel="Get Started"
    titleClassName="mt-20"
  />
);

export default OnboardingDecisions;
