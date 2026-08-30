import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";

const EditProfile = () => (
  <PhoneFrame title="Edit Profile" footer={<BottomNav active="profile" />}>
    <div className="flex h-full flex-col gap-4">
      <div className="mt-2 flex items-center gap-3 text-sm font-semibold">
        <button type="button" className="text-white/80 transition hover:text-white">←</button>
        <span>Edit Profile</span>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="flex flex-col items-center">
          <div className="relative h-20 w-20 rounded-full bg-white/10">
            <span className="absolute -bottom-1 -right-1 flex h-6 w-6 items-center justify-center rounded-full bg-fuchsia-500 text-[10px]">✎</span>
          </div>
          <div className="mt-3 text-sm font-semibold">Alexa Johnson</div>
          <div className="text-[10px] text-white/50">alexa@ridesync.com</div>
        </div>

        <div className="mt-4 space-y-3">
          <div>
            <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Full Name</div>
            <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="Alexa Johnson" />
          </div>
          <div>
            <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Email Address</div>
            <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="alexa@ridesync.com" />
          </div>
          <div>
            <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Phone Number</div>
            <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="+233 24 123 4567" />
          </div>
          <div>
            <div className="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Location</div>
            <input className="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90" defaultValue="Accra, Ghana" />
          </div>
        </div>
      </div>

      <div className="rounded-3xl border border-white/10 bg-white/5 p-4">
        <div className="text-xs font-semibold text-white/70">Ride Preferences</div>
        <div className="mt-3 grid grid-cols-3 gap-2">
          <button className="rounded-full bg-fuchsia-500/20 px-3 py-1 text-[10px] font-semibold text-fuchsia-300">Fastest</button>
          <button className="rounded-full bg-white/10 px-3 py-1 text-[10px] text-white/60">Comfort</button>
          <button className="rounded-full bg-white/10 px-3 py-1 text-[10px] text-white/60">Cheapest</button>
        </div>
        <div className="mt-4 flex items-center justify-between rounded-2xl bg-white/5 px-3 py-2 text-xs">
          <span>Price alerts</span>
          <span className="h-4 w-8 rounded-full bg-fuchsia-500/70"></span>
        </div>
        <div className="mt-2 flex items-center justify-between rounded-2xl bg-white/5 px-3 py-2 text-xs">
          <span>Night alerts</span>
          <span className="h-4 w-8 rounded-full bg-white/10"></span>
        </div>
      </div>

      <button className="mt-auto w-full rounded-full bg-fuchsia-500 py-3 text-sm font-semibold text-white shadow-glow">Save Changes</button>
    </div>
  </PhoneFrame>
);

export default EditProfile;
