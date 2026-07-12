/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Cairo', 'system-ui', 'ui-sans-serif', 'sans-serif'],
      },

      colors: {
        primary: {
          900: '#0A74B3',
          700: '#1483D0',
          600: '#2B96E6',
          500: '#5EB8F8',
          400: '#90CCFF',
          200: '#D4EEFF',
        },

        grayCustom: {
          900: '#333333',
          700: '#555555',
          500: '#888888',
          300: '#E5E5E5',
          100: '#ffffff',
        },
      },
    },
  },

  plugins: [
     require('@tailwindcss/line-clamp'),
  ],
}
