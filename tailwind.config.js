module.exports = {
  purge: [
    './resources/**/*.blade.php',

     './resources/**/*.js',

     './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: { 
      backgroundColor: {
        page: 'var(--page-background-color)',
        card: 'var(--card-background-color)',
        button: 'var(--button-background-color)',
        header: 'var(--header-background-color)'
      },
      colors: {
        default: 'var(--text-default-color)'
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
