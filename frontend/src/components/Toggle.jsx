const Toggle = ({ label, value }) => (
  <button
    type="button"
    className="flex w-full items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-left transition hover:bg-white/10"
    aria-pressed={value}
  >
    <span className="text-sm text-white/80">{label}</span>
    <span
      className={`relative inline-flex h-5 w-9 items-center rounded-full border transition ${
        value ? "border-fuchsia-500 bg-fuchsia-500/70" : "border-white/30 bg-white/10"
      }`}
    >
      <span
        className={`absolute h-3.5 w-3.5 rounded-full bg-white transition ${
          value ? "translate-x-4" : "translate-x-1"
        }`}
      />
    </span>
  </button>
);

export default Toggle;
