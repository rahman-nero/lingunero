/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.{vue,js,ts,jsx,tsx}",
        './resources/**/*.blade.php',
    ],
    theme: {
        fontFamily: {
            'sans': ['Roboto', 'ui-sans-serif', 'system-ui', 'sans-serif', '"Apple Color Emoji"', '"Segoe UI Emoji"', '"Segoe UI Symbol"', '"Noto Color Emoji"'],
        },
        extend: {},
    },
    plugins: [require('tailwindcss-primeui')]
}
