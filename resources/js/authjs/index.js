document.addEventListener("DOMContentLoaded", () => {
    // -----------------------------
    // Carousel Initialization
    // -----------------------------
    const introCarousel = document.querySelector("#introCarousel");
    if (introCarousel) {
        new bootstrap.Carousel(introCarousel, {
            interval: 6000,
            ride: "carousel",
            wrap: true,
        });
    }

    // -----------------------------
    // Smooth Scrolling for Anchors
    // -----------------------------
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", (e) => {
            e.preventDefault();
            const target = document.querySelector(anchor.getAttribute("href"));
            if (target) {
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });

    // Optional: Bootstrap tooltips if you use them
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
});
