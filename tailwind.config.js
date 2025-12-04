module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.{html,js,vue}',
    ],

    theme: {
        fontFamily: {
            Futura: ['Futura', "cursive"],
            FuturaItalic: ['FuturaItalic', "cursive"],
            FuturaMedium: ['FuturaMedium', "cursive"],
            FuturaBold: ['FuturaBold', "cursive"],
            FuturaLtCnBT:['FuturaLtCnBT', 'cursive'],
            FuturaMdCnBT:['FuturaMdCnBT','cursive'],
            FuturaBdCnBT:['FuturaBdCnBT', 'cursive'],
            Nunito : ['Roboto', 'sans-serif'],
        },
        extend: {
            colors: {
                primary: '#0496ff',
                secondary: '#3B8FF2',
                aero: '#106BC7',
            },
            boxShadow: {
                '3xl': 'rgba(0, 0, 0, 0.16) 0px 1px 4px',
            },
        },
    },

    plugins: [require('@tailwindcss/forms'),require('tailwindcss-debug-screens'),],
};
