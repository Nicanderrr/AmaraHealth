import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";

const RideMatch = () => (
  <PhoneFrame title="RideSync+" footer={<BottomNav active="ride" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-1">
        <div className="text-sm font-semibold">RideSync+</div>
        <div className="text-[10px] text-white/50">To: 124 Madison Ave, NY</div>
      </div>

      <div className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-xs">
        <div>
          <div className="text-fuchsia-300">Surge Pricing Active</div>
          <div className="text-[10px] text-white/50">Higher demand in East Legon. Prices and ETAs are slightly higher than usual.</div>
        </div>
        <button className="text-white/40">×</button>
      </div>

      <div className="flex gap-2 text-[10px] font-semibold">
        <button className="rounded-full bg-fuchsia-500/20 px-3 py-1 text-fuchsia-300">Fastest</button>
        <button className="rounded-full bg-white/10 px-3 py-1 text-white/60">Cheapest</button>
        <button className="rounded-full bg-white/10 px-3 py-1 text-white/60">Comfort</button>
      </div>

      <div>
        <div className="text-[10px] uppercase tracking-[0.2em] text-white/40">Best recommendation</div>
        <div className="mt-2 rounded-3xl border border-white/10 bg-white/5 p-4">
          <div className="flex items-center justify-between">
            <div>
              <div className="text-[10px] text-white/50">UBERX • 4 mins away</div>
              <div className="mt-1 text-2xl font-semibold">₵24.50</div>
            </div>
            <div className="text-right">
              <div className="rounded-full bg-fuchsia-500/20 px-2 py-1 text-[9px] text-fuchsia-300">Top Rated</div>
              <div className="mt-2 text-sm font-semibold">UBER</div>
            </div>
          </div>
          <div className="mt-4 flex items-center justify-between">
            <div className="flex items-center gap-2 text-[10px]">
              <div className="h-7 w-7 rounded-full bg-white/10" />
              <div>
                <div className="text-white/80">David L.</div>
                <div className="text-white/50">⭐ 4.9 (2.4k trips)</div>
              </div>
            </div>
            <button className="rounded-full bg-fuchsia-500 px-4 py-2 text-[10px] font-semibold">Book Now</button>
          </div>
        </div>
      </div>

      <div>
        <div className="text-[10px] uppercase tracking-[0.2em] text-white/40">Alternative rides</div>
        <div className="mt-2 space-y-2">
          {[
            { label: "Bolt Economy", price: "₵21.80", meta: "6 mins • 4.7", tag: "Economy", badge: { text: "B", bg: "bg-emerald-500/20", color: "text-emerald-300" } },
            { label: "Yango Comfort", price: "₵28.20", meta: "8 mins • 4.8", tag: "Economy", badge: { text: "Y", bg: "bg-amber-500/20", color: "text-amber-300" } },
            { label: "Uber Black", price: "₵45.00", meta: "3 mins • 5.0", tag: "Comfort", badge: { text: "U", bg: "bg-slate-500/20", color: "text-slate-200" } }
          ].map((ride) => (
            <div key={ride.label} className="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
              <div className="flex items-center gap-3">
                <span className={`flex h-8 w-8 items-center justify-center rounded-full ${ride.badge.bg} text-sm font-semibold ${ride.badge.color}`}>
                  {ride.badge.text}
                </span>
                <div>
                  <div className="text-sm font-semibold">{ride.label}</div>
                  <div className="text-[10px] text-white/50">{ride.meta}</div>
                </div>
              </div>
              <div className="text-right">
                <div className="text-sm font-semibold text-fuchsia-400">{ride.price}</div>
                <div className="text-[9px] text-white/40">{ride.tag}</div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  </PhoneFrame>
);

export default RideMatch;
