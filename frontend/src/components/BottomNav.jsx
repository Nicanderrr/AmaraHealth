import { Link, useLocation } from "react-router-dom";
import { HomeIcon, ChartIcon, UserIcon, HistoryIcon, MapIcon } from "./Icons.jsx";

const BottomNav = ({ active = "home" }) => {
  const location = useLocation();
  const items = [
    { id: "home", icon: HomeIcon, label: "HOME", path: "/home" },
    { id: "history", icon: HistoryIcon, label: "HISTORY", path: "/history" },
    { id: "map", icon: MapIcon, label: "MAP", path: "/explore", center: true },
    { id: "insights", icon: ChartIcon, label: "Insights", path: "/insights" },
    { id: "profile", icon: UserIcon, label: "PROFILE", path: "/profile" }
  ];

  return (
    <div className="relative">
      <div className="flex items-end justify-between gap-2 bg-[#220b15]/95 px-4 pb-3 pt-4">
        {items.map((item) => {
          const Icon = item.icon;
          const isActive = location.pathname === item.path || item.id === active;

          if (item.center) {
            return (
              <Link
                key={item.id}
                to={item.path}
                className="relative -mt-6 flex h-14 w-14 items-center justify-center rounded-full bg-fuchsia-500 shadow-[0_8px_25px_rgba(255,79,154,0.45)]"
              >
                <span className="flex h-11 w-11 items-center justify-center rounded-full bg-[#2a0f1c] text-white">
                  <Icon className="h-5 w-5" />
                </span>
              </Link>
            );
          }

          return (
            <Link
              key={item.id}
              to={item.path}
              className={`flex flex-1 flex-col items-center gap-1 text-[10px] font-semibold uppercase tracking-[0.15em] transition ${
                isActive ? "text-fuchsia-400" : "text-white/50 hover:text-white"
              }`}
            >
              <Icon className="h-5 w-5" />
              <span className="text-[9px] tracking-[0.2em]">{item.label}</span>
            </Link>
          );
        })}
      </div>
    </div>
  );
};

export default BottomNav;
