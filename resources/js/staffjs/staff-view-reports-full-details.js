let currentImageIndex = 0;
let images = [];

document.addEventListener("DOMContentLoaded", () => {
    /* =============================
       IMAGE GALLERY MODAL FUNCTIONALITY
    ============================= */
    images = document.querySelectorAll(".thumbnail");

    window.openImageModal = function (index) {
        if (!images.length) return;

        currentImageIndex = index;
        const modal = document.getElementById("imageModal");
        const img = images[currentImageIndex];

        document.getElementById("expandedImg").src =
            img.dataset.full || img.src;
        document.getElementById("caption").textContent = img.alt || "Image";
        modal.style.display = "flex";

        document.querySelector(".prev").style.display =
            images.length > 1 ? "block" : "none";
        document.querySelector(".next").style.display =
            images.length > 1 ? "block" : "none";
    };

    window.closeModal = function () {
        document.getElementById("imageModal").style.display = "none";
    };

    window.changeImage = function (step) {
        if (!images.length) return;

        currentImageIndex =
            (currentImageIndex + step + images.length) % images.length;
        const img = images[currentImageIndex];

        document.getElementById("expandedImg").src =
            img.dataset.full || img.src;
        document.getElementById("caption").textContent = img.alt || "Image";
    };

    window.onclick = function (event) {
        const modal = document.getElementById("imageModal");
        if (event.target === modal) {
            closeModal();
        }
    };

    document.addEventListener("keydown", function (e) {
        const modalOpen =
            document.getElementById("imageModal").style.display === "flex";
        if (!modalOpen) return;

        if (e.key === "ArrowRight") changeImage(1);
        if (e.key === "ArrowLeft") changeImage(-1);
        if (e.key === "Escape") closeModal();
    });

    const trackBtn = document.getElementById("trackReportBtn");
    const reportStatusEl = document.getElementById("reportStatus");
    const reportStatus = reportStatusEl
        ? reportStatusEl.textContent.trim().toLowerCase()
        : "";

    if (reportStatus === "success") {
        // Hide Track Report button
        if (trackBtn) trackBtn.style.display = "none";

        // Optionally add a "Resolved" badge where the button was
        if (trackBtn && !document.querySelector(".resolved-badge")) {
            const badge = document.createElement("span");
            badge.className = "badge bg-success resolved-badge ms-2";
            badge.innerHTML =
                '<i class="fa-solid fa-check-circle me-1"></i> Report Resolved';
            trackBtn.insertAdjacentElement("afterend", badge);
        }
    }
});
