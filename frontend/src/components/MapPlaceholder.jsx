const MapPlaceholder = ({ className = "" }) => (
  <div className={`relative overflow-hidden rounded-2xl bg-[#f4e9f0] ${className}`}>
    <svg viewBox="0 0 320 200" className="h-full w-full" aria-hidden="true">
      <defs>
        <linearGradient id="water" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stopColor="#d9f0ff" />
          <stop offset="1" stopColor="#c3e6ff" />
        </linearGradient>
      </defs>
      <rect width="320" height="200" fill="#f7eef4" />
      <path d="M220 20c30 15 55 45 75 70v110H200c-12-30-5-70 20-95 15-15 20-40 0-55Z" fill="url(#water)" />
      <path d="M18 34h110l45 35h70l50-20" stroke="#d4c1cf" strokeWidth="6" fill="none" />
      <path d="M10 120h140l30-20h95l30 25" stroke="#e2cfd9" strokeWidth="5" fill="none" />
      <path d="M55 70h60l18 18h50l30-10" stroke="#dbc7d4" strokeWidth="4" fill="none" />
      <path d="M30 160h80l40-15h60" stroke="#e7d6df" strokeWidth="3" fill="none" />
      <circle cx="96" cy="120" r="10" fill="#ff4f9a" />
      <circle cx="210" cy="70" r="8" fill="#ff65ad" />
      <circle cx="250" cy="135" r="7" fill="#ff7db7" />
      <rect x="22" y="18" width="60" height="18" rx="9" fill="#3a1426" opacity="0.85" />
      <text x="30" y="31" fill="#f9d6e6" fontSize="9" fontFamily="Poppins, sans-serif">Accra</text>
      <text x="178" y="140" fill="#b08fa1" fontSize="8" fontFamily="Poppins, sans-serif">Labadi</text>
      <text x="120" y="92" fill="#b08fa1" fontSize="8" fontFamily="Poppins, sans-serif">Airport</text>
      <circle cx="96" cy="120" r="4" fill="#ffffff" />
    </svg>
    <div className="absolute bottom-3 left-3 rounded-full bg-[#2a0f1c]/75 px-3 py-1 text-[10px] text-pink-200 backdrop-blur-sm">
      High Demand Zone
    </div>
    <button type="button" className="absolute bottom-3 right-3 flex h-8 w-8 items-center justify-center rounded-full bg-[#2a0f1c]/75 text-pink-200 backdrop-blur-sm">
      ⤢
    </button>
  </div>
);

export default MapPlaceholder;
