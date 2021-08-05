const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins'],
      },
      colors: {
        'custom': {
          50: '#e0f2f1',
          100: '#b2dfdb',
          200: '#80cbc4',
          300: '#4db6ac',
          400: '#26a69a',
          500: '#009688',
          600: '#00897b',
          700: '#00796b',
          800: '#00695c',
          900: '#004d40',
          'accent-100': '#a7ffeb',
          'accent-200': '#64ffda',
          'accent-400': '#1de9b6',
          'accent-700': '#00bfa5',
        },
        amber: {
          50: '#fff8e1',
          100: '#ffecb3',
          200: '#ffe082',
          300: '#ffd54f',
          400: '#ffca28',
          500: '#ffc107',
          600: '#ffb300',
          700: '#ffa000',
          800: '#ff8f00',
          900: '#ff6f00',
          'accent-100': '#ffe57f',
          'accent-200': '#ffd740',
          'accent-400': '#ffc400',
          'accent-700': '#ffab00',
        },
        facebook: {
          DEFAULT: '#3b5998',
        },
        twitter: {
          DEFAULT: '#08a0e9',
        },
        discord: {
          DEFAULT: '#7289da',
        },
        cyan: {
          50: '#e0f7fa',
          100: '#b2ebf2',
          200: '#80deea',
          300: '#4dd0e1',
          400: '#26c6da',
          500: '#00bcd4',
          600: '#00acc1',
          700: '#0097a7',
          800: '#00838f',
          900: '#006064',
          'accent-100': '#84ffff',
          'accent-200': '#18ffff',
          'accent-400': '#00e5ff',
          'accent-700': '#00b8d4',
        },
      },
      spacing: {
        '7': '1.75rem',
        '9': '2.25rem',
        '28': '7rem',
        '80': '20rem',
        '96': '24rem',
      },
      height: {
        '1/2': '50%',
      },
      scale: {
        '30': '.3',
      },
      boxShadow: {
        outline: '0 0 0 3px rgba(46, 204, 177, 0.4)',
      },
    },
  },
  variants: {
    scale: ['responsive', 'hover', 'focus', 'group-hover'],
    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    opacity: ['responsive', 'hover', 'focus', 'group-hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
    translate: ({after}) => after(['group-hover']),
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};