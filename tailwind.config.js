/** @type {import('tailwindcss').Config} */
const {fontFamily} = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors")
module.exports = {
    content: [
        './app/Filament/**/*.php',
        './resources/**/*.blade.php',
        './vendor/filament-panels/**/*.blade.php',
    ],
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "2rem",
            },
        },
        extend: {
            colors: {
                blue:{
                    200: '#CEE7ED',
                    500: '#3EB1C8',
                }
            },
            backgroundImage: {
                'meeting': 'url(\'/assets/meeting.jpg\')',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}

