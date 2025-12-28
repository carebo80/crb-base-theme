/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./assets/js/**/*.js",
    // auch das Plugin scannen:
    "../wp-plugins/crb-components/**/*.php",
    "../wp-plugins/crb-components/assets/js/**/*.js",
    "./node_modules/preline/dist/*.js"
  ],
  theme: {
    extend: {
      container: {
        center: true,
        padding: "1rem",
      },
    },
  },
  plugins: [
    require('preline/plugin'),
  ],
};
