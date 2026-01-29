// theme.js
// Handles Dark/Light mode toggle for 63Sats Bank

document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;

    // Check local storage
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        html.classList.add("dark");
    } else if (savedTheme === "light") {
        html.classList.remove("dark");
    }

    // If there's a toggle button, attach listener
    const toggle = document.getElementById("themeToggle");

    if (toggle) {
        toggle.addEventListener("click", () => {
            html.classList.toggle("dark");

            // Save preference
            if (html.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    }
});
