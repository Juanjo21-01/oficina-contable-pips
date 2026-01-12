import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                gray: {
                    50: "#f9fafb",
                    100: "#f4f5f7",
                    200: "#e5e7eb",
                    300: "#d5d6d7",
                    400: "#9e9e9e",
                    500: "#707275",
                    600: "#4c4f52",
                    700: "#24262d",
                    800: "#1a1c23",
                    900: "#121317",
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
