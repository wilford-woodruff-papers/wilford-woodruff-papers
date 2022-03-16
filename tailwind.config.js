const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
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
                    '50': 'rgb(11, 40, 54, .5)',
                    '80': 'rgb(11, 40, 54, .8)',
                },
                'secondary': {
                    'DEFAULT': '#792310',
                },
                'highlight': {
                    'DEFAULT': '#B4A677',
                },
                'polaroid': {
                    'DEFAULT': '#F0EDDE',
                },
                'white': {
                    'DEFAULT': '#FFFFFF',
                    '80': 'rgb(255, 255, 255, .8)',
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
