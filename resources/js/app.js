import "./bootstrap";
import Chart from "chart.js/auto";

window.Chart = Chart;

document.addEventListener("alpine:init", () => {
    Alpine.store("theme", {
        isDark: document.documentElement.classList.contains("dark"),
        toggle() {
            this.isDark = !this.isDark;
            document.documentElement.classList.toggle("dark", this.isDark);
            localStorage.setItem("theme", this.isDark ? "dark" : "light");
        },
    });

    Alpine.store("sidebar", {
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        close() {
            this.isOpen = false;
        },
    });
});

// Ctrl+K or / → focus active search input
document.addEventListener("keydown", (e) => {
    const tag = (document.activeElement?.tagName ?? "").toLowerCase();
    const inInput =
        ["input", "textarea", "select"].includes(tag) ||
        document.activeElement?.isContentEditable;
    if ((e.key === "/" && !inInput) || (e.ctrlKey && e.key === "k")) {
        e.preventDefault();
        const search = document.querySelector(".search-wrap input");
        if (search) {
            search.focus();
            search.select();
        }
    }
});
