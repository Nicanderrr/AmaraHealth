import { Link } from "react-router-dom";

const Pill = ({ children, active = false, to }) => {
  const className = `rounded-full border px-4 py-1.5 text-xs font-medium transition ${
    active
      ? "border-fuchsia-500 bg-fuchsia-500 text-white shadow-glow"
      : "border-white/20 text-white/70 hover:border-white/40 hover:text-white"
  }`;

  if (to) {
    return (
      <Link to={to} className={className}>
        {children}
      </Link>
    );
  }

  return (
    <button className={className} type="button">
      {children}
    </button>
  );
};

export default Pill;
