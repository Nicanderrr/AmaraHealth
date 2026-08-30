import { MapContainer, TileLayer, Marker } from "react-leaflet";
import PhoneFrame from "../components/PhoneFrame.jsx";
import BottomNav from "../components/BottomNav.jsx";

const Explore = () => (
  <PhoneFrame
    title="Explore"
    hideStatus
    contentClassName="p-0 overflow-hidden"
    backgroundClassName="bg-black"
    showGlow={false}
    footer={<BottomNav active="explore" />}
  >
    <div className="relative h-full w-full">
      <MapContainer
        center={[5.651, -0.187]}
        zoom={15}
        className="absolute inset-0 h-full w-full z-[1]"
        zoomControl={false}
      >
        <TileLayer
          attribution='&copy; OpenStreetMap contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />
        <Marker position={[5.651, -0.187]} />
      </MapContainer>

      <div className="map-overlays pointer-events-none">
        <div className="pointer-events-auto mx-auto mt-4 w-[78%] rounded-full bg-black/55 px-4 py-2 text-center text-xs font-semibold text-white/80 backdrop-blur">
          Explore Ride Conditions
        </div>

        <div className="pointer-events-auto mx-auto mt-3 flex w-[85%] items-center gap-2 rounded-full bg-black/55 px-4 py-2 text-[10px] text-white/70 backdrop-blur">
          <span className="text-fuchsia-400">⌕</span>
          Search destination or tap map
        </div>

        <div className="pointer-events-auto mx-auto mt-3 flex w-[85%] gap-2">
          {[
            "Home",
            "Work",
            "Airport"
          ].map((chip) => (
            <button
              key={chip}
              className="rounded-full bg-black/55 px-3 py-1 text-[10px] text-white/70 backdrop-blur"
              type="button"
            >
              {chip}
            </button>
          ))}
        </div>

        <div className="pointer-events-auto mx-auto mt-6 w-[78%] rounded-3xl bg-black/65 p-4 text-center text-white/80 backdrop-blur">
          <div className="text-xs font-semibold">Osu, Accra</div>
          <div className="text-[10px] text-white/50">Oxford Street District</div>
          <div className="mt-3 flex items-center justify-between text-[10px] text-white/50">
            <span>Avg price</span>
            <span>ETA</span>
          </div>
          <div className="mt-1 flex items-center justify-between text-sm font-semibold">
            <span>GHS 30</span>
            <span>5–7 min</span>
          </div>
          <button className="mt-3 w-full rounded-full bg-fuchsia-500 py-2 text-[10px] font-semibold text-white" type="button">
            Compare Rides
          </button>
        </div>

        <div className="pointer-events-auto absolute right-4 top-[46%] flex flex-col gap-2">
          <button className="h-8 w-8 rounded-full bg-black/55 text-white/80 backdrop-blur" type="button">+</button>
          <button className="h-8 w-8 rounded-full bg-black/55 text-white/80 backdrop-blur" type="button">−</button>
        </div>

        <div className="pointer-events-auto absolute bottom-20 left-4 right-4 rounded-full bg-black/65 px-4 py-2 text-[10px] text-white/70 backdrop-blur">
          Best area nearby: East Legon (Cheapest rides now)
        </div>
      </div>
    </div>
  </PhoneFrame>
);

export default Explore;
