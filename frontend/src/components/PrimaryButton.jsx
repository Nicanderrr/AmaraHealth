const PrimaryButton = ({ children, className = "", ...props }) => (
  <button
    className={`h-11 w-full rounded-full bg-fuchsia-500 px-4 text-sm font-semibold tracking-[0.02em] text-white shadow-glow transition hover:bg-fuchsia-600 hover:shadow-soft ${className}`}
    {...props}
  >
    {children}
  </button>
);

export default PrimaryButton;
