import colors from 'tailwindcss/colors';
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */

const primary = colors.green;

const colorConfig = {
    dark: {
        ...colors.slate,
        DEFAULT: '#1F2937'
    },
    white: {
        DEFAULT: '#FFFFFF',
        light: '#E0E6ED'
    },
    light: '#F5F8FA',
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
};

export default {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{ts,tsx}'
    ],

    theme: {
        extend: {
            colors: colorConfig,
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans]
            }
        }
    },

    plugins: [forms]
};
