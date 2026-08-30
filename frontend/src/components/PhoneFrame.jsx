import StatusBar from "./StatusBar.jsx";

const PhoneFrame = ({
  title,
  children,
  footer,
  hideStatus = false,
  contentClassName = "",
  backgroundClassName = "bg-app",
  showGlow = true
}) => (
  <div className={`relative flex h-screen w-full flex-col overflow-hidden rounded-none border border-white/10 shadow-soft ${backgroundClassName}`}>
    {showGlow ? (
      <>
        <div className="absolute -left-10 -top-16 h-32 w-32 rounded-full bg-fuchsia-500/20 blur-2xl" />
        <div className="absolute -right-12 top-36 h-28 w-28 rounded-full bg-fuchsia-400/20 blur-2xl" />
      </>
    ) : null}
    {!hideStatus && <StatusBar title={title} />}
    <div
      className={`relative flex-1 text-white scrollbar-hide ${
        hideStatus ? "" : "overflow-y-auto px-5 pb-24 pt-2"
      } ${contentClassName}`}
    >
      {children}
    </div>
    {footer ? <div className="sticky bottom-0 z-10 shrink-0">{footer}</div> : null}
  </div>
);

export default PhoneFrame;
