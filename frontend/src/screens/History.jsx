import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";

const History = () => (
  <PhoneFrame title="History" footer={<BottomNav active="history" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-2 flex items-center justify-between text-sm font-semibold">
        <div className="flex items-center gap-3">
          <button type="button" className="text-white/80 transition hover:text-white">←</button>
          <span>History</span>
        </div>
        <button type="button" className="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[10px] font-semibold text-white/70">Last 30 Days</button>
      </div>

      {[
        {
          route: "East Legon → Airport",
          time: "Oct 24, 10:30 AM • 12.4 km",
          price: "GHS 25",
          note: "Compared 3 platforms • Bolt was cheapest"
        },
        {
          route: "Osu → Labadi Beach",
          time: "Oct 22, 06:15 PM • 6.2 km",
          price: "GHS 18",
          note: "Compared 2 platforms • Uber was fastest"
        }
      ].map((item) => (
        <div key={item.route} className="rounded-3xl border border-white/10 bg-white/5 p-4">
          <div className="flex items-center justify-between">
            <div>
              <div className="text-sm font-semibold">{item.route}</div>
              <div className="mt-1 text-[10px] text-white/50">{item.time}</div>
            </div>
            <div className="text-right">
              <div className="text-[10px] text-white/40">BEST OPTION</div>
              <div className="text-sm font-semibold text-fuchsia-400">{item.price}</div>
            </div>
          </div>
          <div className="mt-3 flex items-center gap-2 text-[10px] text-white/50">
            <span className="rounded-full bg-emerald-500/20 px-2 py-1 text-[9px] font-semibold text-emerald-300">U</span>
            <span className="rounded-full bg-fuchsia-500/20 px-2 py-1 text-[9px] font-semibold text-fuchsia-300">B</span>
            <span className="rounded-full bg-amber-500/20 px-2 py-1 text-[9px] font-semibold text-amber-300">Y</span>
            <span>{item.note}</span>
          </div>
          <div className="mt-3 flex gap-2">
            <button className="flex-1 rounded-full bg-fuchsia-500 px-3 py-2 text-[10px] font-semibold text-white">Repeat Search</button>
            <button className="flex-1 rounded-full border border-white/10 bg-white/5 px-3 py-2 text-[10px] font-semibold text-white/70">Details</button>
          </div>
        </div>
      ))}

      <div className="mt-3 flex flex-col items-center gap-2 text-xs text-white/40">
        <div className="h-12 w-12 rounded-full border border-white/10 border-dashed" />
        <span>End of History</span>
        <span className="text-[10px]">You’ve reached the end of your recent trips.</span>
      </div>
    </div>
  </PhoneFrame>
);

export default History;
