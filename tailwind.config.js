import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/livewire/flux/stubs/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                // Primary (Indigo) — brand institucional, CTA, headers activos
                primary: {
                    50:  "#eef2ff",
                    100: "#e0e7ff",
                    200: "#c7d2fe",
                    300: "#a5b4fc",
                    400: "#818cf8",
                    500: "#6366f1",
                    600: "#4f46e5",
                    700: "#4338ca",
                    800: "#3730a3",
                    900: "#312e81",
                    950: "#1e1b4b",
                },
                // Accent (Teal) — highlights, charts, selected tab, marca secundaria
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
                // Neutrales (Slate) — nueva base para texto y superficies
                slate: {
                    50:  "#f8fafc",
                    100: "#f1f5f9",
                    200: "#e2e8f0",
                    300: "#cbd5e1",
                    400: "#94a3b8",
                    500: "#64748b",
                    600: "#475569",
                    700: "#334155",
                    800: "#1e293b",
                    900: "#0f172a",
                    950: "#020617",
                },
                // Legacy gray — mantenido para compatibilidad durante migración
                gray: {
                    50:  "#f9fafb",
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
                // Semantic surface tokens
                surface: {
                    DEFAULT:    "#ffffff",
                    muted:      "#f8fafc",
                    dark:       "#0f172a",
                    "dark-muted": "#1e293b",
                },
                // Action color tokens
                action: {
                    view:   "#9333ea", // purple-600
                    edit:   "#ea580c", // orange-600
                    delete: "#e11d48", // rose-600
                    add:    "#4f46e5", // primary-600
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
                sans:    ['"Inter Variable"', "Inter", ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans Variable"', "Plus Jakarta Sans", ...defaultTheme.fontFamily.sans],
                mono:    ['"JetBrains Mono Variable"', "JetBrains Mono", ...defaultTheme.fontFamily.mono],
            },
            borderRadius: {
                card:   "0.5rem",
                badge:  "9999px",
                button: "0.375rem",
            },
            boxShadow: {
                card: "0 1px 3px 0 rgb(0 0 0 / .08), 0 1px 2px -1px rgb(0 0 0 / .08)",
                "card-hover": "0 4px 6px -1px rgb(0 0 0 / .1), 0 2px 4px -2px rgb(0 0 0 / .1)",
            },
        },
    },

    plugins: [forms],
};
