module.exports = {
  mode: 'jit',
  content: ["./**/*.php", "./src/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        gugi: ["Gugi", "serif"],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};
