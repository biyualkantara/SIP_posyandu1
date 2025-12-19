/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{html,js}",
    "./!(build|dist|.*)/**/*.{html,js}"
  ],
  theme: {
    extend: {
      colors: {
        white: "#fff",
        darkslategray: {
          100: "#455a64",
          200: "#333",
          300: "#222d32"
        },
        black: "#000",
        gray: {
          100: "#9a8c8c",
          200: "rgba(255, 255, 255, 0.24)",
          300: "rgba(255, 255, 255, 0.16)",
          400: "rgba(255, 255, 255, 0)"
        },
        gainsboro: {
          100: "#dadada",
          200: "#d9d9d9",
          300: "rgba(217, 217, 217, 0)"
        },
        darkgray: "#9d9d9d",
        whitesmoke: "#f5f5f5",
        deepskyblue: "#00abd6",
        tomato: "#ff7043",
        forestgreen: "#4caf50",
        red: "#ff0000",
        steelblue: "#337ab7"
      },
      fontFamily: {
        inter: ["Inter", "sans-serif"],
        roboto: ["Roboto", "sans-serif"],
        righteous: ["Righteous", "cursive"],
        poppins: ["Poppins", "sans-serif"]
      },
      borderRadius: {
        'num-3': "3px"
      }
    }
  },
  corePlugins: {
    preflight: false
  }
}
