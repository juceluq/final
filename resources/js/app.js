import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    const theme =
        localStorage.getItem("theme") ??
        (window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light");
    document.documentElement.classList.toggle("dark", theme === "dark");

    // Actualizar los íconos del botón
    darkIcon.style.display = theme === "dark" ? "block" : "none";
    lightIcon.style.display = theme === "light" ? "block" : "none";

    btn.addEventListener("click", function () {
        let isDarkMode = document.documentElement.classList.toggle("dark");
        localStorage.setItem("theme", isDarkMode ? "dark" : "light");

        // Toggle icons visibility
        darkIcon.style.display = isDarkMode ? "block" : "none";
        lightIcon.style.display = !isDarkMode ? "block" : "none";
    });
});
