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
                // Base gray palette
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
                // Brand token — single source of truth (replaces scattered teal-600/sky-600)
                brand: {
                    50:  "#f0fdfa",
                    100: "#ccfbf1",
                    200: "#99f6e4",
                    300: "#5eead4",
                    400: "#2dd4bf",
                    500: "#14b8a6",
                    600: "#0d9488",
                    700: "#0f766e",
                    800: "#115e59",
                    900: "#134e4a",
                },
                // Semantic surface tokens
                surface: {
                    DEFAULT: "#ffffff",
                    muted:   "#f9fafb",
                    dark:    "#1a1c23",
                    "dark-muted": "#24262d",
                },
                // Action color tokens
                action: {
                    view:   "#9333ea", // purple-600
                    edit:   "#ea580c", // orange-600
                    delete: "#e11d48", // rose-600
                    add:    "#0d9488", // brand-600
                },
                // Status color tokens
                status: {
                    active:   "#0d9488", // brand-600
                    inactive: "#e11d48", // rose-600
                    pending:  "#d97706", // amber-600
                    info:     "#2563eb", // blue-600
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                card:   "0.5rem",  // rounded-lg
                badge:  "9999px",  // rounded-full
                button: "0.375rem", // rounded-md
            },
            boxShadow: {
                card: "0 1px 3px 0 rgb(0 0 0 / .08), 0 1px 2px -1px rgb(0 0 0 / .08)",
                "card-hover": "0 4px 6px -1px rgb(0 0 0 / .1), 0 2px 4px -2px rgb(0 0 0 / .1)",
            },
        },
    },

    plugins: [forms],
};
