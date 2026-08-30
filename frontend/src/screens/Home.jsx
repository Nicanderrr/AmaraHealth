import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import PrimaryButton from "../components/PrimaryButton.jsx";
import BottomNav from "../components/BottomNav.jsx";
import MapPlaceholder from "../components/MapPlaceholder.jsx";
import { RideIcon } from "../components/Icons.jsx";

const Home = () => (
  <PhoneFrame title="RideSync+" footer={<BottomNav active="home" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-2 flex items-center justify-between">
        <div className="flex items-center gap-2 text-xs font-semibold">
          <span className="flex h-8 w-8 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
            <RideIcon className="h-4 w-4" />
          </span>
          <span>RideSync+</span>
        </div>
        <div className="h-9 w-9 rounded-full bg-white/10" />
      </div>

      <div>
        <h2 className="text-2xl font-semibold">
          Where to, <span className="text-fuchsia-400">Alexa</span>?
        </h2>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/50">Pickup</div>
        <div className="mt-2 flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm">
          <span className="flex h-8 w-8 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">◎</span>
          <span>123 Innovation Drive, Tech City</span>
        </div>
        <div className="mt-4 text-[10px] font-semibold uppercase tracking-[0.2em] text-white/50">Destination</div>
        <div className="mt-2 flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/70">
          <span className="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white/60">⌖</span>
          <span>Where are you heading?</span>
        </div>
        <div className="mt-4">
          <Link to="/ride-match">
            <PrimaryButton>Compare Rides →</PrimaryButton>
          </Link>
        </div>
      </div>

      <MapPlaceholder className="h-44" />

      <div className="flex items-center justify-between text-xs font-semibold">
        <span className="text-white/80">Saved Location</span>
        <button className="text-fuchsia-400">Clear all</button>
      </div>

      <div className="space-y-3">
        {[
          {
            title: "Computer Science Depart.",
            meta: "3.2 miles away • 12 mins ago",
            icon: "💼"
          },
          {
            title: "Home (Kwapong Hall)",
            meta: "5.2 miles away • 2 hours ago",
            icon: "🏠"
          },
          {
            title: "Poki Restaurant",
            meta: "9.2 miles away • Yesterday",
            icon: "☕"
          }
        ].map((item) => (
          <Link
            key={item.title}
            to="/edit-location"
            className="flex items-center justify-between rounded-3xl border border-white/10 bg-white/5 px-4 py-3"
          >
            <div className="flex items-center gap-3">
              <span className="flex h-10 w-10 items-center justify-center rounded-full bg-fuchsia-500/15 text-lg">
                {item.icon}
              </span>
              <div>
                <div className="text-sm font-semibold">{item.title}</div>
                <div className="text-[10px] text-white/50">{item.meta}</div>
              </div>
            </div>
            <span className="text-white/40">›</span>
          </Link>
        ))}
      </div>
    </div>
  </PhoneFrame>
);

export default Home;
