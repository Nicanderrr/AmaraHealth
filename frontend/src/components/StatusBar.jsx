import { useNavigate } from "react-router-dom";

const StatusBar = ({ title }) => {
  const navigate = useNavigate();

  return (
    <div className="relative flex items-center justify-between px-5 pt-4 text-xs text-white/80">
      <button
        type="button"
        onClick={() => navigate(-1)}
        className="flex items-center gap-1 text-white/80 transition hover:text-white"
        aria-label="Go back"
      >
        <span className="text-base">←</span>
        <span className="text-[11px] font-medium">Back</span>
      </button>
      <span className="text-[10px] uppercase tracking-[0.2em] text-white/60">{title}</span>
      <div className="flex items-center gap-1">
        <span className="h-2 w-2 rounded-full bg-white/70" />
        <span className="h-2 w-2 rounded-full bg-white/70" />
        <span className="h-2 w-2 rounded-full bg-white/70" />
      </div>
    </div>
  );
};

export default StatusBar;
