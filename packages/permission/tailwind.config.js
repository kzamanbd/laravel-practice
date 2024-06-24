import forms from "@tailwindcss/forms";
import colors from "tailwindcss/colors";
import defaultTheme from "tailwindcss/defaultTheme";

const primary = colors.green;
const colorConfig = {
    dark: {
        ...colors.slate,
        DEFAULT: "#1F2937",
    },
    white: {
        DEFAULT: "#FFFFFF",
        light: "#E0E6ED",
    },
    light: "#F5F8FA",
    primary: {
        ...primary,
        DEFAULT: "#00A76F",
    },
    info: {
        ...colors.indigo,
        DEFAULT: colors.indigo[500],
    },
    danger: {
        ...colors.rose,
        DEFAULT: colors.rose[500],
    },
    success: {
        ...colors.emerald,
        DEFAULT: colors.emerald[500],
    },
    warning: {
        ...colors.amber,
        DEFAULT: colors.amber[500],
    },
    secondary: {
        ...colors.gray,
        DEFAULT: colors.gray[400],
    },
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],

    darkMode: "class", // or 'media'

    theme: {
        themeVariants: ["dark", "light"],
        extend: {
            colors: colorConfig,
            maxHeight: {
                0: "0",
                xl: "36rem",
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
