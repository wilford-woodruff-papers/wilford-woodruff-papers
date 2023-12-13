const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './vendor/wire-elements/modal/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        {
            pattern: /bg-(secondary)-(100|200|300|400|500|600|700|800|900)/,
            variants: ['hover', 'focus'],
        },
        {
            pattern: /w-(1\/4|1\/23\/4)/,
            variants: ['sm','md','lg','xl'],
        },
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Source Sans Pro', 'sans-serif'],
                serif: ['Source Serif Pro', 'serif'],
            },
            colors: {
                'primary': {
                    'DEFAULT': '#0B2836',
                    '10': 'rgb(11, 40, 54, .1)',
                    '20': 'rgb(11, 40, 54, .2)',
                    '30': 'rgb(11, 40, 54, .3)',
                    '40': 'rgb(11, 40, 54, .4)',
                    '50': 'rgb(11, 40, 54, .5)',
                    '60': 'rgb(11, 40, 54, .6)',
                    '70': 'rgb(11, 40, 54, .7)',
                    '80': 'rgb(11, 40, 54, .8)',
                },
                'secondary': {
                    'DEFAULT': '#792310',
                    '100': 'rgba(228, 211, 207)',
                    '200': 'rgb(205, 174, 167)',
                    '300': 'rgb(183, 138, 128)',
                    '400': 'rgb(162, 103, 90)',
                    '500': 'rgb(140, 68, 51)',
                    '600': 'rgb(113, 33, 14)',
                    '700': 'rgb(103, 30, 13)',
                    '800': 'rgb(93, 27, 12)',
                    '900': 'rgb(84, 24, 10)',
                },
                'highlight': {
                    'DEFAULT': '#B4A677',
                },
                'accent': {
                    'DEFAULT': 'rgb(217, 232, 237)',
                    '100': 'rgba(217, 232, 237, .1)',
                    '200': 'rgba(217, 232, 237, .2)',
                    '300': 'rgba(217, 232, 237, .3)',
                    '400': 'rgba(217, 232, 237, .4)',
                    '500': 'rgba(217, 232, 237, .5)',
                    '600': 'rgba(217, 232, 237, .6)',
                    '700': 'rgba(217, 232, 237, .7)',
                    '800': 'rgba(217, 232, 237, .8)',
                    '900': 'rgba(217, 232, 237, .9)',
                },
                'polaroid': {
                    'DEFAULT': '#F0EDDE',
                },
                'white': {
                    'DEFAULT': '#FFFFFF',
                    '80': 'rgb(255, 255, 255, .8)',
                },
                'light-blue': {
                    'DEFAULT': '#DBEAEF',
                    '500': '#E2E9EF',
                    '600': '#DBEAEF',
                },
                'light-gray': {
                    'DEFAULT': '#707070',
                    '400': '#00000029',
                    '500': '#A8A8A8',
                    '600': '#0B2836',
                },
                'dark-blue': {
                    'DEFAULT': '#0B2836',
                    '500': '#0E3240',
                    '600': '#0B2836',
                },
            },
            width: {
                '112': '28rem',
                '128': '32rem',
            },
            height: {
                '112': '28rem',
                '128': '32rem',
            },
            zIndex: {
                '100': '100',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
