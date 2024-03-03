import forms from "@tailwindcss/forms";
import colors from "tailwindcss/colors";
import defaultTheme from "tailwindcss/defaultTheme";

const primary = colors.sky;

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],

    darkMode: "class", // or 'media'

    theme: {
        themeVariants: ["dark", "light"],
        extend: {
            colors: {
                dark: {
                    primary: "#1E1E2D",
                    secondary: "#151521",
                },
                light: {
                    gray: "#F5F8FA",
                },
                primary: {
                    100: primary[100],
                    200: primary[200],
                    300: primary[300],
                    400: primary[400],
                    500: primary[500],
                    600: primary[600],
                    700: primary[700],
                    800: primary[800],
                    900: primary[900],
                    DEFAULT: primary[500],
                },
                info: "#56B6F7",
                danger: colors.red[500],
                success: colors.green[600],
                warning: colors.yellow[500],
                secondary: primary[300],
            },
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
