import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    darkMode: "class",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
                mono: ["JetBrains Mono", ...defaultTheme.fontFamily.mono],
            },
            colors: {
                // Theme 1: Modern Professional (Default)
                modern: {
                    primary: {
                        DEFAULT: "#2563EB",
                        light: "#3B82F6",
                        dark: "#1E40AF",
                    },
                    bg: "#F8FAFC",
                    surface: "#FFFFFF",
                    text: { primary: "#0F172A", secondary: "#475569" },
                },
                // Theme 2: Dark Finance
                dark: {
                    primary: {
                        DEFAULT: "#6366F1",
                        light: "#818CF8",
                        dark: "#4F46E5",
                    },
                    bg: "#0F172A",
                    surface: "#1E293B",
                    text: { primary: "#F1F5F9", secondary: "#94A3B8" },
                },
                // Theme 3: Indian Heritage
                indian: {
                    primary: {
                        DEFAULT: "#E67E22",
                        light: "#F0A04B",
                        dark: "#C96A1E",
                    },
                    bg: "#FFF8F0",
                    surface: "#FFFFFF",
                    text: { primary: "#1A1A2E", secondary: "#5A5A7A" },
                },
                // Theme 4: Glassmorphism
                glass: {
                    primary: {
                        DEFAULT: "#8B5CF6",
                        light: "#A78BFA",
                        dark: "#7C3AED",
                    },
                    bg: "#667EEA",
                    surface: "rgba(255,255,255,0.15)",
                    text: { primary: "#FFFFFF", secondary: "#E2E8F0" },
                },
                // Theme 5: Neo-Brutalist
                brutal: {
                    primary: {
                        DEFAULT: "#000000",
                        light: "#333333",
                        dark: "#000000",
                    },
                    accent: "#FFD700",
                    bg: "#FAFAFA",
                    surface: "#FFFFFF",
                    text: { primary: "#000000", secondary: "#555555" },
                },
                // Status colors (consistent across themes)
                status: {
                    draft: "#94A3B8",
                    sent: "#3B82F6",
                    viewed: "#8B5CF6",
                    accepted: "#10B981",
                    paid: "#059669",
                    overdue: "#EF4444",
                    cancelled: "#6B7280",
                },
            },
            borderRadius: {
                card: "8px",
                glass: "16px",
                brutal: "0px",
            },
            boxShadow: {
                card: "0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06)",
                "card-hover":
                    "0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06)",
                brutal: "4px 4px 0px #000000",
                "brutal-hover": "6px 6px 0px #000000",
                glass: "0 8px 32px rgba(0,0,0,0.1)",
            },
        },
    },

    plugins: [forms],
};
