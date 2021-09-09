module.exports = {
  purge: {
    content: [
      './templates/**/*.html.twig',
      './assets/**/*.css',
      './assets/**/*.js',
    ],
    safelist: [
        //categories
      'text-pink-500',
      'text-yellow-500',
      'text-green-500',
      'bg-pink-100',
      'bg-yellow-100',
      'bg-green-100',
    ],
  },
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
    display: ['responsive', 'hover', 'focus', 'group-hover'],
    translate: ({after}) => after(['group-hover']),
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};