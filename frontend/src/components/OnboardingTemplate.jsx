import { Link } from "react-router-dom";
import PhoneFrame from "./PhoneFrame.jsx";
import PrimaryButton from "./PrimaryButton.jsx";

const MiniHomeIcon = ({ className = "" }) => (
  <svg viewBox="0 0 24 24" className={className} fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M4 11.5 12 5l8 6.5v7a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 5 18.5v-7Z" stroke="currentColor" strokeWidth="1.4" />
    <path d="M9.5 20v-6h5v6" stroke="currentColor" strokeWidth="1.4" />
  </svg>
);

const MiniBriefcaseIcon = ({ className = "" }) => (
  <svg viewBox="0 0 24 24" className={className} fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="4" y="7.5" width="16" height="11" rx="2" stroke="currentColor" strokeWidth="1.4" />
    <path d="M9 7.5V6a1.5 1.5 0 0 1 1.5-1.5h3A1.5 1.5 0 0 1 15 6v1.5" stroke="currentColor" strokeWidth="1.4" />
  </svg>
);

const MiniSchoolIcon = ({ className = "" }) => (
  <svg viewBox="0 0 24 24" className={className} fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M4 9.5 12 6l8 3.5-8 3.5-8-3.5Z" stroke="currentColor" strokeWidth="1.4" />
    <path d="M8.5 12.8V16c0 1.2 7 1.2 7 0v-3.2" stroke="currentColor" strokeWidth="1.4" />
  </svg>
);

const MiniPinIcon = ({ className = "" }) => (
  <svg viewBox="0 0 24 24" className={className} fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 21s6-5.3 6-10a6 6 0 1 0-12 0c0 4.7 6 10 6 10Z" stroke="currentColor" strokeWidth="1.4" />
    <circle cx="12" cy="11" r="2.4" fill="currentColor" />
  </svg>
);

const MiniTrendIcon = ({ className = "" }) => (
  <svg viewBox="0 0 24 24" className={className} fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M4 16l6-6 4 4 6-7" stroke="currentColor" strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round" />
    <circle cx="10" cy="10" r="1" fill="currentColor" />
  </svg>
);

const HeroCompare = () => (
  <div className="relative h-[240px] w-[240px] overflow-visible bg-transparent">
    <div className="absolute inset-0 translate-x-1 translate-y-2 rotate-[5deg] scale-[0.98] rounded-[36px] border border-fuchsia-500/40 bg-gradient-to-br from-fuchsia-500/60 via-fuchsia-500/30 to-transparent opacity-90 blur-[6px]" />
    <div className="absolute inset-0 rotate-[-7.5deg]">
      <div className="absolute inset-0 rounded-[36px] border border-fuchsia-500/40 bg-[#2a0f1c]/35">
        <div className="absolute inset-3 overflow-hidden rounded-[28px] bg-[#3a1426]/70">
          <img
            src="/mapphoto.png"
            alt=""
            className="h-full w-full object-cover opacity-70"
            draggable="false"
          />
          <div className="pointer-events-none absolute inset-0 bg-fuchsia-500/15" />
        </div>
        <div className="absolute left-1/2 top-[42%] h-5 w-5 -translate-x-1/2 rounded-full bg-fuchsia-500/30" />
        <div className="absolute left-1/2 top-[39%] h-3.5 w-3.5 -translate-x-1/2 rounded-full bg-fuchsia-500" />
        <div className="absolute left-1/2 top-[37%] h-5 w-5 -translate-x-1/2 rounded-full border-2 border-fuchsia-400/70" />
        <div className="absolute bottom-6 left-1/2 flex w-[176px] -translate-x-1/2 items-center justify-between rounded-full border border-fuchsia-500/30 bg-[#2a0f1c]/70 px-4 py-2 text-[10px] text-fuchsia-200">
          <span className="flex items-center gap-2">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
              <svg viewBox="0 0 24 24" className="h-4 w-4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 13.5L6.3 7.7C6.7 6.7 7.7 6 8.8 6h6.4c1.1 0 2.1.7 2.5 1.7L20 13.5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
                <path d="M4 13.5h16v2.4a1.6 1.6 0 0 1-1.6 1.6H5.6A1.6 1.6 0 0 1 4 15.9v-2.4Z" stroke="currentColor" strokeWidth="1.5" />
                <circle cx="7.2" cy="15.8" r="1.2" fill="currentColor" />
                <circle cx="16.8" cy="15.8" r="1.2" fill="currentColor" />
              </svg>
            </span>
            <span className="h-1.5 w-8 rounded-full bg-fuchsia-500/50" />
          </span>
          <span className="font-semibold">GHS 12.50</span>
        </div>
      </div>
    </div>
  </div>
);

const HeroFavorites = () => (
  <div className="relative h-[240px] w-[240px] overflow-visible bg-transparent">
    <div className="absolute inset-0 translate-x-1 translate-y-2 rotate-[5deg] scale-[0.98] rounded-[36px] border border-fuchsia-500/40 bg-gradient-to-br from-fuchsia-500/60 via-fuchsia-500/30 to-transparent opacity-90 blur-[6px]" />
    <div className="absolute inset-0 rotate-[-7.5deg]">
      <div className="absolute inset-0 rounded-[36px] border border-fuchsia-500/40 bg-[#2a0f1c]/35">
        <div className="absolute left-1/2 top-8 flex -translate-x-1/2 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
          <MiniPinIcon className="h-5 w-5" />
        </div>

        <div className="absolute left-6 top-[120px] flex flex-col items-center gap-1 text-[10px] text-white/60">
          <span className="flex h-9 w-9 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
            <MiniHomeIcon className="h-4 w-4" />
          </span>
          <span>Home</span>
          <span className="text-[9px] text-white/40">Set address</span>
        </div>

        <div className="absolute left-1/2 top-[126px] flex -translate-x-1/2 flex-col items-center gap-1 text-[10px] text-white/60">
          <span className="flex h-9 w-9 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
            <MiniBriefcaseIcon className="h-4 w-4" />
          </span>
          <span>Work</span>
          <span className="text-[9px] text-white/40">Set address</span>
        </div>

        <div className="absolute right-6 top-[120px] flex flex-col items-center gap-1 text-[10px] text-white/60">
          <span className="flex h-9 w-9 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
            <MiniSchoolIcon className="h-4 w-4" />
          </span>
          <span>School</span>
          <span className="text-[9px] text-white/40">Set address</span>
        </div>
      </div>
    </div>
  </div>
);

const HeroInsights = () => (
  <div className="relative h-[240px] w-[240px] overflow-visible bg-transparent">
    <div className="absolute inset-0 translate-x-1 translate-y-2 rotate-[5deg] scale-[0.98] rounded-[36px] border border-fuchsia-500/40 bg-gradient-to-br from-fuchsia-500/60 via-fuchsia-500/30 to-transparent opacity-90 blur-[6px]" />
    <div className="absolute inset-0 rotate-[-7.5deg]">
      <div className="absolute inset-0 rounded-[36px] border border-fuchsia-500/40 bg-[#2a0f1c]/35 p-5 text-[10px] text-white/70">
        <div className="mt-8 flex items-start justify-between">
          <div>
            <div className="uppercase tracking-[0.22em] text-[8.5px] text-fuchsia-300">Price Trend</div>
            <div className="mt-1 text-[13px] font-semibold text-white">-12%</div>
            <div className="text-[9px] text-emerald-300">dropping</div>
          </div>
          <div className="flex h-7 w-7 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
            <MiniTrendIcon className="h-4 w-4" />
          </div>
        </div>
        <div className="absolute left-[-19px] top-[110px] w-[277px] rounded-[26px] border border-fuchsia-500/40 bg-[#2a0f1c]/55 px-4 py-3 text-[10px] text-white/80">
          <div className="absolute left-[5px] top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-fuchsia-500 text-white">
            <svg viewBox="0 0 24 24" className="h-4 w-4" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 4l1.3 3.2 3.5 1.2-3.1 1.2-1.7 3-1.7-3-3.1-1.2 3.5-1.2L12 4Z" fill="currentColor" />
              <path d="M6 14l.7 1.7 1.8.6-1.6.6-.9 1.5-.9-1.5-1.6-.6 1.8-.6L6 14Z" fill="currentColor" />
              <path d="M18 13.5l.6 1.4 1.5.5-1.3.5-.8 1.3-.8-1.3-1.3-.5 1.5-.5.6-1.4Z" fill="currentColor" />
            </svg>
          </div>
          <div className="flex items-center justify-between pl-[40px]">
            <div className="font-semibold text-white">Smart Recommendation</div>
            <span className="text-white/40">&gt;</span>
          </div>
          <div className="mt-1 pl-[40px] text-white/60">UberX is cheaper than Bolt at 3:00pm</div>
        </div>
        <div className="absolute bottom-6 right-5 flex h-7 w-7 items-center justify-center rounded-full bg-fuchsia-500/20 text-fuchsia-300">
          <MiniPinIcon className="h-4 w-4" />
        </div>
      </div>
    </div>
  </div>
);

const heroMap = {
  compare: HeroCompare,
  favorites: HeroFavorites,
  insights: HeroInsights
};

const OnboardingTemplate = ({
  title,
  subtitle,
  nextPath,
  step = 1,
  activeDot = 2,
  nextLabel = "Next ->",
  showSkip = false,
  hero = "compare",
  titleClassName = ""
}) => {
  const Hero = heroMap[hero] ?? HeroCompare;
  return (
    <PhoneFrame hideStatus contentClassName="px-6 pb-12 pt-5">
      <div className="relative flex h-full flex-col">
        <div className="pointer-events-none absolute inset-0 noise-overlay opacity-10" />
        <div className="relative flex items-center justify-center text-[11px] font-semibold text-white/80">
          <button type="button" className="absolute left-0 text-base text-fuchsia-400">x</button>
          RideSync+
        </div>

        <div className="mt-10 flex flex-col items-center text-center">
          <div className="pointer-events-none">
            <Hero />
          </div>
          <h2 className={`mt-6 text-[22px] font-semibold leading-tight text-white ${titleClassName}`}>{title}</h2>
          <p className="mt-2 max-w-[240px] text-[11px] leading-[1.5] text-white/60">{subtitle}</p>
        </div>

        <div className="relative z-10 mt-auto text-center">
          <div className="mb-3 flex items-center justify-center gap-2">
            {[1, 2, 3].map((dot) => (
              <span
                key={dot}
                className={`h-2 rounded-full ${
                  activeDot === dot ? "w-6 bg-fuchsia-500" : "w-2 bg-white/20"
                }`}
              />
            ))}
          </div>
          <Link to={nextPath} className="pointer-events-auto">
            <PrimaryButton className="flex items-center justify-center gap-2 text-sm">
              <span>{nextLabel}</span>
            </PrimaryButton>
          </Link>
          {showSkip ? (
            <Link to="/login" className="mt-3 inline-block text-[10px] text-white/40 pointer-events-auto">
              Skip intro
            </Link>
          ) : null}
        </div>
      </div>
    </PhoneFrame>
  );
};

export default OnboardingTemplate;
