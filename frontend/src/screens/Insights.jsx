import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";
import { RideIcon, PinIcon } from "../components/Icons.jsx";

const Insights = () => (
  <PhoneFrame title="Insights" footer={<BottomNav active="insights" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-2 flex items-center gap-3 text-sm font-semibold">
        <button type="button" className="text-white/80 transition hover:text-white">←</button>
        <span>Insights</span>
      </div>

      <button type="button" className="rounded-3xl border border-white/10 bg-white/5 p-4 text-left">
        <div className="flex items-center justify-between text-xs text-white/60">
          <span>Daily Ride Trends</span>
          <span className="rounded-full bg-emerald-400/20 px-2.5 py-1 text-[10px] font-semibold text-emerald-300">+12% Traffic</span>
        </div>
        <div className="mt-2 text-lg font-semibold">Peak: 8:00 AM</div>
        <div className="mt-4 rounded-2xl bg-[#1f0b14] px-3 py-4">
          <svg viewBox="0 0 240 80" className="h-16 w-full">
            <path d="M0 52 C20 30, 60 12, 90 24 C110 32, 130 52, 150 50 C170 48, 190 26, 220 14 L240 6" stroke="#ff4f9a" strokeWidth="3" fill="none" />
          </svg>
          <div className="mt-2 flex justify-between text-[10px] text-white/40">
            <span>6AM</span>
            <span>12PM</span>
            <span>6PM</span>
            <span>12AM</span>
          </div>
        </div>
      </button>

      <button type="button" className="relative overflow-hidden rounded-3xl bg-fuchsia-500 px-4 py-5 text-left">
        <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/80">Best time to ride</div>
        <div className="mt-2 text-xl font-semibold">10:30 AM – 3:00 PM</div>
        <p className="mt-2 text-xs text-white/80">Lowest traffic and average 15% fare reduction in Accra.</p>
        <RideIcon className="pointer-events-none absolute -right-4 -bottom-6 h-24 w-24 text-white/20" />
      </button>

      <div>
        <div className="flex items-center gap-2 text-xs font-semibold text-white/70">
          <span className="text-fuchsia-400">▲</span>
          <span>Surge Pricing Alerts</span>
        </div>
        <div className="mt-3 space-y-3">
          <button type="button" className="w-full rounded-2xl border border-fuchsia-500/40 bg-white/5 px-4 py-3 text-left">
            <div className="flex items-center justify-between">
              <div>
                <div className="text-sm font-semibold">Osu & Airport City</div>
                <div className="text-[10px] text-white/50">High demand due to events</div>
              </div>
              <span className="text-sm font-semibold text-fuchsia-400">2.1x</span>
            </div>
          </button>
          <button type="button" className="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-left">
            <div className="flex items-center justify-between">
              <div>
                <div className="text-sm font-semibold">Kwame Nkrumah Circle</div>
                <div className="text-[10px] text-white/50">Moderate congestion</div>
              </div>
              <span className="text-sm font-semibold text-white/60">1.4x</span>
            </div>
          </button>
        </div>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-xs font-semibold uppercase tracking-[0.2em] text-white/50">Price Comparison (GHC)</div>
        <div className="mt-3 space-y-3 text-xs">
          {[
            { label: "Uber", value: "GHC 42.00 avg", width: "w-[90%]" },
            { label: "Bolt", value: "GHC 35.50 avg", width: "w-[75%]" },
            { label: "Yango", value: "GHC 38.00 avg", width: "w-[82%]" }
          ].map((item) => (
            <button key={item.label} type="button" className="w-full text-left">
              <div className="flex justify-between text-[10px] text-white/60">
                <span>{item.label}</span>
                <span>{item.value}</span>
              </div>
              <div className="mt-2 h-2 rounded-full bg-white/10">
                <div className={`h-2 rounded-full bg-fuchsia-500 ${item.width}`} />
              </div>
            </button>
          ))}
        </div>
        <div className="mt-4 flex items-center gap-2 rounded-2xl bg-fuchsia-500/20 px-3 py-2 text-[10px] text-fuchsia-200">
          <PinIcon className="h-4 w-4" />
          <span>Smart Tip: Bolt is currently the most affordable option in East Legon.</span>
        </div>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-xs font-semibold text-white/60">Popular Routes</div>
        <div className="mt-3 space-y-2 text-xs">
          {[
            { id: 1, route: "East Legon → Airport", time: "15 min • Every 4 mins" },
            { id: 2, route: "Madina → Circle", time: "32 min • High Demand" },
            { id: 3, route: "Osu → Tema", time: "45 min • Morning Peak" }
          ].map((route) => (
            <button key={route.id} type="button" className="flex w-full items-center justify-between rounded-2xl bg-white/5 px-3 py-2 text-left">
              <div className="flex items-center gap-2">
                <span className="flex h-5 w-5 items-center justify-center rounded-full bg-fuchsia-500/20 text-[10px] font-semibold text-fuchsia-300">
                  {route.id}
                </span>
                <div>
                  <div className="text-sm font-semibold">{route.route}</div>
                  <div className="text-[10px] text-white/50">{route.time}</div>
                </div>
              </div>
              <span className="text-white/40">›</span>
            </button>
          ))}
        </div>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-xs font-semibold text-white/60">Demand Map</div>
        <div className="mt-3 rounded-2xl bg-[#1f0b14] p-4">
          <div className="relative flex h-28 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500/20 to-transparent">
            <div className="absolute h-24 w-24 rounded-full bg-fuchsia-500/30 blur-2xl" />
            <div className="relative flex h-10 w-10 items-center justify-center rounded-full bg-fuchsia-500">
              <PinIcon className="h-5 w-5 text-white" />
            </div>
          </div>
          <div className="mt-3 text-center text-xs text-white/70">Accra Central</div>
          <div className="mt-1 text-center text-[10px] text-white/40">Live demand</div>
        </div>
      </div>
    </div>
  </PhoneFrame>
);

export default Insights;
