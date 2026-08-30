import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import PrimaryButton from "../components/PrimaryButton.jsx";
import { RideIcon } from "../components/Icons.jsx";

const Splash = () => (
  <PhoneFrame title="RideSync+">
    <div className="flex h-full flex-col items-center justify-center gap-7 text-center">
      <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-fuchsia-500/20 text-fuchsia-400 shadow-glow">
        <RideIcon className="h-8 w-8" />
      </div>
      <div>
        <h1 className="text-2xl font-semibold tracking-wide">RideSync+</h1>
        <p className="mt-2 text-xs text-white/60">Smart ride matching in your city.</p>
      </div>
      <div className="w-full pt-6">
        <Link to="/onboarding/compare">
          <PrimaryButton>Get Started</PrimaryButton>
        </Link>
      </div>
    </div>
  </PhoneFrame>
);

export default Splash;
