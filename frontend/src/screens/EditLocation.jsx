import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import PrimaryButton from "../components/PrimaryButton.jsx";
import MapPlaceholder from "../components/MapPlaceholder.jsx";

const EditLocation = () => (
  <PhoneFrame title="Edit Location">
    <div className="flex h-full flex-col gap-4">
      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-sm font-semibold">Edit Location</div>
        <p className="mt-1 text-[10px] text-white/50">Update your saved place for quicker booking</p>
        <div className="mt-4 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Location Label</div>
        <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="Home" />
        <div className="mt-4 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Address</div>
        <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="742 Evergreen Terrace, Springfield" />
        <div className="mt-4 rounded-2xl border border-white/10 bg-white/5 p-3">
          <MapPlaceholder className="h-24" />
          <button className="mt-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[10px] text-white/60">Change Map</button>
        </div>
      </div>
      <div className="mt-auto">
        <Link to="/home">
          <PrimaryButton>Save Changes</PrimaryButton>
        </Link>
      </div>
    </div>
  </PhoneFrame>
);

export default EditLocation;
