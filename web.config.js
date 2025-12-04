const colors = require('tailwindcss/colors')
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.{html,js,vue}',
  ],
    important: true,
    theme: {
        screens: {
            xs: "540px",
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
        },
        fontFamily: {
            Futura: ['Futura', "cursive"],
            FuturaItalic: ['FuturaItalic', "cursive"],
            FuturaMedium: ['FuturaMedium', "cursive"],
            FuturaBold: ['FuturaBold', "cursive"],
            Nunito : ['Roboto', 'sans-serif'],
            FuturaLtCnBT:['FuturaLtCnBT', 'cursive'],
            FuturaMdCnBT:['FuturaMdCnBT','cursive'],
            FuturaBdCnBT:['FuturaBdCnBT', 'cursive']
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '12px',
                sm: '1rem',
                lg: '45px',
                xl: '5rem',
                '2xl': '8rem',
            },

        },
        extend: {
            colors: {
                primary: '#006EB7',
                secondary: '#111827',
                aero: '#106BC7',
                xblue: '#0496ff',
            },
             backgroundImage: {
                'map': "url('/assets/images/map.png')",
            },
            boxShadow: {
                sm: '0 2px 4px 0 rgb(60 72 88 / 0.15)',
                DEFAULT: '0 0 3px rgb(60 72 88 / 0.15)',
                md: '0 5px 13px rgb(60 72 88 / 0.20)',
                lg: '0 10px 25px -3px rgb(60 72 88 / 0.15)',
                xl: '0 20px 25px -5px rgb(60 72 88 / 0.1), 0 8px 10px -6px rgb(60 72 88 / 0.1)',
                '2xl': '0 25px 50px -12px rgb(60 72 88 / 0.25)',
                inner: 'inset 0 2px 4px 0 rgb(60 72 88 / 0.05)',
                testi: '2px 2px 2px -1px rgb(60 72 88 / 0.15)',
                glow: '0 0 4px rgb(0 0 0 / 0.1)',
            },
            maxWidth: ({
                theme,
                breakpoints
            }) => ({
                '1200': '71.25rem',
                '992': '60rem',
                '768': '45rem',
            })
        },
    },
    plugins: [require('@tailwindcss/forms'),require('tailwindcss-debug-screens'),],
}
