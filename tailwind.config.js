const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
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

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
