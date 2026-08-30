/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,jsx}"] ,
  theme: {
    extend: {
      colors: {
        plum: {
          900: "#1a0911",
          800: "#220b15",
          700: "#2a0f1c",
          650: "#2f111f",
          600: "#3a1426",
          500: "#4a1730"
        },
        fuchsia: {
          600: "#ff4f9a",
          500: "#ff3b8d",
          400: "#ff65ad"
        },
        roseglow: "#ff7db7",
        soft: "#f6d9e6"
      },
      fontFamily: {
        sans: ["Poppins", "ui-sans-serif", "system-ui"]
      },
      boxShadow: {
        glow: "0 0 30px rgba(255, 79, 154, 0.35)",
        soft: "0 10px 40px rgba(0,0,0,0.35)"
      },
      borderRadius: {
        card: "22px",
        phone: "28px"
      }
    }
  },
  plugins: []
};
