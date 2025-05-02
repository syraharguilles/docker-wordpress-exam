// tailwind.config.js
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './**/*.php',
    './blocks/**/*.{js,jsx}',
    './assets/**/*.{js,css}',
  ],
  theme: {
    extend: {
      typography: ({ theme }) => ({
        DEFAULT: {
          css: {
            color: theme('colors.gray.800'),
            a: {
              color: theme('colors.blue.600'),
              '&:hover': {
                textDecoration: 'underline',
              },
              fontWeight: '500',
            },
            h1: { fontWeight: '700' },
            h2: { fontWeight: '700' },
            h3: { fontWeight: '600' },
            blockquote: {
              fontStyle: 'italic',
              borderLeftColor: theme('colors.gray.300'),
              color: theme('colors.gray.600'),
            },
            code: {
              backgroundColor: theme('colors.gray.100'),
              padding: '2px 4px',
              borderRadius: theme('borderRadius.sm'),
              fontSize: '0.875em',
            },
            img: {
              borderRadius: theme('borderRadius.lg'),
              marginTop: '1rem',
              marginBottom: '1rem',
            },
          },
        },
        dark: {
          css: {
            color: theme('colors.gray.300'),
            a: {
              color: theme('colors.blue.400'),
            },
            blockquote: {
              borderLeftColor: theme('colors.gray.600'),
              color: theme('colors.gray.400'),
            },
            code: {
              backgroundColor: theme('colors.gray.800'),
              color: theme('colors.pink.300'),
            },
          },
        },
      }),
    },
  },
  plugins: [require('@tailwindcss/typography')],
  darkMode: 'class', // or 'media' if you prefer
};
