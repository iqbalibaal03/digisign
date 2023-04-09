const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  darkMode: "class",
  theme: {
    fontFamily: {
      sans: ["Inter", ...defaultTheme.fontFamily.sans],
    },
    extend: {
      animation: {
        "grow-in": "growIn .15s ease-in",
        "collapse-enter": "collapseEnter .15s ease-in",
        "collapse-leave": "collapseLeave .15s ease-in",
      },
      keyframes: {
        growIn: {
          "0%": {
            opacity: 0,
          },
          "100%": {
            opacity: 1,
          },
        },
        collapseEnter: {
          "0%": {
            "max-height": "0",
            opacity: ".25",
          },
          "100%": {
            "max-height": "768px",
            opacity: "1",
          },
        },
        collapseLeave: {
          "0%": {
            "max-height": "768px",
            opacity: "1",
          },
          "100%": {
            "max-height": "0",
            opacity: ".25",
          },
        },
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
