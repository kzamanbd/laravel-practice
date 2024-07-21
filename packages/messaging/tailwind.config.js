import colors from 'tailwindcss/colors';
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */

const primary = colors.green;

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue'
    ],

    theme: {
        extend: {
            colors: {
                dark: {
                    ...colors.slate,
                    DEFAULT: '#1F2937',
                    primary: '#1E293B',
                    secondary: '#151521'
                },
                white: {
                    DEFAULT: '#FFFFFF',
                    light: '#E0E6ED'
                },
                light: {
                    gray: '#F5F8FA',
                    DEFAULT: '#F5F8FA'
                },
                primary: {
                    ...primary,
                    DEFAULT: primary[500]
                },
                info: {
                    ...colors.indigo,
                    DEFAULT: colors.indigo[500]
                },
                danger: {
                    ...colors.rose,
                    DEFAULT: colors.rose[500]
                },
                success: {
                    ...colors.emerald,
                    DEFAULT: colors.emerald[500]
                },
                warning: {
                    ...colors.amber,
                    DEFAULT: colors.amber[500]
                },
                secondary: {
                    ...colors.gray,
                    DEFAULT: colors.gray[400]
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans]
            }
        }
    },

    plugins: [forms]
};
