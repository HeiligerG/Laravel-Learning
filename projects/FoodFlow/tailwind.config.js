import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Hier nur die Fonts
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            // Hier gehören die Farben hin
            colors: {
                brandIndigo: '#6366F1', // dein Indigo
                brandDark:   '#0F172A', // dunkle Farbe
                brandGreen:  '#145314', // grüne Farbe

                green: {
                    900: '#0f3d33',
                    800: '#145743',
                    700: '#115e59',
                    600: '#16a34a',
                    500: '#22c55e',
                },
                gray: {
                    50:  '#f9fafb',
                    200: '#e5e7eb',
                },
                red: {
                    500: '#dc2626',
                    700: '#b91c1c',
                },
                yellow: {
                    500: '#facc15',
                    400: '#fbbf24',
                },
            },
        },
    },

    plugins: [forms],
};
