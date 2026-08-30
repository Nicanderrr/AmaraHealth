import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";
import { RideIcon, PinIcon } from "../components/Icons.jsx";

const Profile = () => (
  <PhoneFrame title="Profile" footer={<BottomNav active="profile" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-4 flex flex-col items-center">
        <div className="relative h-20 w-20 rounded-full bg-white/10">
          <span className="absolute bottom-1 right-1 h-5 w-5 rounded-full border-2 border-[#2a0f1c] bg-fuchsia-500" />
        </div>
        <div className="mt-3 text-base font-semibold">Alexa Johnson</div>
        <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-fuchsia-400">RideSync+</div>
        <Link
          to="/edit-profile"
          className="mt-4 rounded-full bg-fuchsia-500 px-6 py-2 text-xs font-semibold text-white shadow-glow"
        >
          Edit Profile
        </Link>
      </div>

      <div className="mt-2">
        <div className="text-xs font-semibold text-white/80">Ride Preferences</div>
        <div className="mt-3 space-y-3">
          <div className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
            <div className="flex items-center gap-3">
              <span className="flex h-8 w-8 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
                <RideIcon className="h-4 w-4" />
              </span>
              <span className="text-sm text-white/80">Prioritize Cost</span>
            </div>
            <span className="relative inline-flex h-5 w-10 items-center rounded-full bg-fuchsia-500/70">
              <span className="absolute right-1 h-3.5 w-3.5 rounded-full bg-white" />
            </span>
          </div>
          <div className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
            <div className="flex items-center gap-3">
              <span className="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white/60">
                <PinIcon className="h-4 w-4" />
              </span>
              <span className="text-sm text-white/60">Prioritize Time</span>
            </div>
            <span className="relative inline-flex h-5 w-10 items-center rounded-full bg-white/10">
              <span className="absolute left-1 h-3.5 w-3.5 rounded-full bg-white/70" />
            </span>
          </div>
        </div>
      </div>

      <div className="mt-2">
        <div className="flex items-center justify-between">
          <span className="text-xs font-semibold text-white/80">Recent History</span>
          <Link to="/history" className="text-[10px] font-semibold text-fuchsia-400">
            View All
          </Link>
        </div>
        <div className="mt-3 space-y-3">
          {[
            {
              label: "Downtown to Airport",
              meta: "Yesterday, 4:30 PM • Uber vs Lyft",
              price: "₵24.50",
              tag: "Saved $5"
            },
            {
              label: "Office to Home",
              meta: "Oct 24 • Lyft Preferred",
              price: "₵18.20",
              tag: "Fastest"
            },
            {
              label: "Office to Home",
              meta: "Oct 24 • Lyft Preferred",
              price: "₵18.20",
              tag: "Fastest"
            }
          ].map((item) => (
            <div key={`${item.label}-${item.price}`} className="flex items-center justify-between rounded-3xl border border-white/10 bg-white/5 px-4 py-3">
              <div className="flex items-center gap-3">
                <span className="flex h-9 w-9 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
                  <PinIcon className="h-4 w-4" />
                </span>
                <div>
                  <div className="text-sm font-semibold">{item.label}</div>
                  <div className="text-[10px] text-white/50">{item.meta}</div>
                </div>
              </div>
              <div className="text-right">
                <div className="text-sm font-semibold text-fuchsia-400">{item.price}</div>
                <div className="text-[9px] text-white/40">{item.tag}</div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  </PhoneFrame>
);

export default Profile;
