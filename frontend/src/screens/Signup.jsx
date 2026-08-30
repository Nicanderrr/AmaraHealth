import { Link } from "react-router-dom";
import PhoneFrame from "../components/PhoneFrame.jsx";
import PrimaryButton from "../components/PrimaryButton.jsx";

const Signup = () => (
  <PhoneFrame title="Create Account">
    <div className="flex h-full flex-col">
      <div>
        <h2 className="text-xl font-semibold">Create Account</h2>
        <p className="mt-2 text-xs text-white/60">Get instant access to live ride rates.</p>
      </div>
      <div className="mt-5 space-y-3">
        <input className="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90 placeholder:text-white/40" placeholder="Full name" />
        <input className="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90 placeholder:text-white/40" placeholder="Email" />
        <input className="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90 placeholder:text-white/40" placeholder="Phone" />
        <input className="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/90 placeholder:text-white/40" placeholder="Password" type="password" />
      </div>
      <div className="mt-5">
        <Link to="/home">
          <PrimaryButton>Create Account</PrimaryButton>
        </Link>
      </div>
      <div className="mt-5 flex items-center gap-3 text-xs text-white/50">
        <span className="h-px flex-1 bg-white/10" />
        sign up with
        <span className="h-px flex-1 bg-white/10" />
      </div>
      <div className="mt-4 flex gap-3">
        <button className="w-full rounded-full border border-white/10 bg-white/5 py-2 text-xs text-white/70 transition hover:border-white/30">
          Google
        </button>
        <button className="w-full rounded-full border border-white/10 bg-white/5 py-2 text-xs text-white/70 transition hover:border-white/30">
          Apple
        </button>
      </div>
      <div className="mt-6 text-center text-xs text-white/50">
        Already have an account? <Link className="text-fuchsia-400" to="/login">Login</Link>
      </div>
    </div>
  </PhoneFrame>
);

export default Signup;
