import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import PrimaryButton from "../components/PrimaryButton.jsx";
import MapPlaceholder from "../components/MapPlaceholder.jsx";

const RideDetails = () => (
  <PhoneFrame title="Ride Details">
    <div className="flex h-full flex-col gap-4">
      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-[10px] uppercase tracking-[0.2em] text-white/50">Live map</div>
        <MapPlaceholder className="mt-3 h-28" />
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="flex items-center justify-between">
          <div>
            <div className="text-sm font-semibold">UberX</div>
            <div className="text-[10px] text-white/50">4 min away</div>
          </div>
          <div className="text-lg font-semibold text-fuchsia-400">₵24.50</div>
        </div>
        <div className="mt-3 flex items-center justify-between text-[10px] text-white/60">
          <span>Pickup</span>
          <span>East Legon</span>
        </div>
        <div className="mt-2 flex items-center justify-between text-[10px] text-white/60">
          <span>Drop-off</span>
          <span>Airport</span>
        </div>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-[10px] uppercase tracking-[0.2em] text-white/50">Driver info</div>
        <div className="mt-3 flex items-center gap-3">
          <div className="h-10 w-10 rounded-full bg-white/10" />
          <div>
            <div className="text-sm font-semibold">Kevin Mensah</div>
            <div className="text-[10px] text-white/50">⭐ 4.9 (1,240)</div>
          </div>
        </div>
      </div>

      <div className="mt-auto">
        <Link to="/home">
          <PrimaryButton>Continue to App</PrimaryButton>
        </Link>
      </div>
    </div>
  </PhoneFrame>
);

export default RideDetails;
