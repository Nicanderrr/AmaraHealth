import PhoneFrame from "../components/PhoneFrame.jsx";
import { RideIcon } from "../components/Icons.jsx";

const Loading = () => (
  <PhoneFrame title="RideSync+">
    <div className="flex h-full flex-col items-center justify-center gap-6">
      <div className="flex h-20 w-20 items-center justify-center rounded-3xl bg-fuchsia-500/20 text-fuchsia-400 shadow-glow">
        <RideIcon className="h-10 w-10" />
      </div>
      <h2 className="text-lg font-semibold">RideSync+</h2>
      <div className="flex gap-2">
        <span className="h-2.5 w-2.5 rounded-full bg-fuchsia-500" />
        <span className="h-2.5 w-2.5 rounded-full bg-fuchsia-500/60" />
        <span className="h-2.5 w-2.5 rounded-full bg-fuchsia-500/30" />
      </div>
      <p className="text-xs text-white/50">Syncing ride options...</p>
    </div>
  </PhoneFrame>
);

export default Loading;
