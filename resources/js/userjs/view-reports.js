let currentImageIndex = 0;
let images = [];

document.addEventListener("DOMContentLoaded", () => {
    // ---------- IMAGE MODAL ----------
    images = document.querySelectorAll(".thumbnail");

    window.openImageModal = function (index) {
        if (!images.length) return;

        currentImageIndex = index;
        const modal = document.getElementById("imageModal");
        if (!modal) return;

        const img = images[currentImageIndex];
        document.getElementById("expandedImg").src = img.dataset.full || img.src;
        document.getElementById("caption").textContent = img.alt || "Image";
        modal.style.display = "flex";

        const prevBtn = modal.querySelector(".prev");
        const nextBtn = modal.querySelector(".next");

        if (prevBtn) prevBtn.style.display = images.length > 1 ? "block" : "none";
        if (nextBtn) nextBtn.style.display = images.length > 1 ? "block" : "none";
    };

    window.closeModal = function () {
        const modal = document.getElementById("imageModal");
        if (modal) modal.style.display = "none";
    };

    window.changeImage = function (step) {
        if (!images.length) return;
        currentImageIndex = (currentImageIndex + step + images.length) % images.length;

        const img = images[currentImageIndex];
        const expandedImg = document.getElementById("expandedImg");
        const caption = document.getElementById("caption");

        if (expandedImg) expandedImg.src = img.dataset.full || img.src;
        if (caption) caption.textContent = img.alt || "Image";
    };

    window.onclick = function (event) {
        const modal = document.getElementById("imageModal");
        if (modal && event.target === modal) closeModal();
    };

    document.addEventListener("keydown", (e) => {
        const modal = document.getElementById("imageModal");
        const modalOpen = modal && modal.style.display === "flex";
        if (!modalOpen) return;

        if (e.key === "ArrowRight") changeImage(1);
        if (e.key === "ArrowLeft") changeImage(-1);
        if (e.key === "Escape") closeModal();
    });

    // ---------- DELETE REQUEST ----------
    const deleteButtons = document.querySelectorAll(".btn-delete-request");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            const form = button.closest("form");
            if (!form) return;

            const isPending = form.dataset.deletePending === "true";
            const reasonInput = form.querySelector(".delete-reason");

            if (isPending) {
                Swal.fire({
                    icon: "info",
                    title: "Pending Request",
                    text: "You already have a pending delete request for this report.",
                    confirmButtonColor: "#d33",
                });
                return;
            }

            Swal.fire({
                title: "Request Deletion",
                input: "textarea",
                inputLabel: "Reason",
                inputPlaceholder: "Please provide a reason for requesting deletion...",
                inputAttributes: { "aria-label": "Reason for deletion" },
                showCancelButton: true,
                confirmButtonText: "Submit Request",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                inputValidator: (value) => (!value.trim() ? "You need to provide a reason!" : null),
            }).then((result) => {
                if (result.isConfirmed && reasonInput) {
                    reasonInput.value = result.value;
                    form.submit();
                }
            });
        });
    });

    // ---------- EDIT REQUEST ----------
    const editButtons = document.querySelectorAll(".btn-edit-request");

    editButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const hasPending = button.dataset.editPending === "true";
            const editUrl = button.dataset.editUrl;

            if (hasPending) {
                Swal.fire({
                    icon: "info",
                    title: "Pending Request",
                    text: "You already have a pending edit request for this report.",
                    confirmButtonColor: "#2563eb",
                });
            } else if (editUrl) {
                window.location.href = editUrl;
            }
        });
    });

    // ---------- LEAFLET MAP ----------
    const mapContainer = document.getElementById("reportMap");
    if (mapContainer) {
        const lat = parseFloat(mapContainer.dataset.lat);
        const lng = parseFloat(mapContainer.dataset.lng);

        if (!isNaN(lat) && !isNaN(lng)) {
            const map = L.map("reportMap", {
                zoomControl: false,
                dragging: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                keyboard: false,
                touchZoom: false,
            }).setView([lat, lng], 15);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: "&copy; OpenStreetMap contributors",
            }).addTo(map);

            L.marker([lat, lng]).addTo(map).bindPopup("Incident Location").openPopup();
        }
    }

    // ---------- HIDE BUTTONS IF REPORT RESOLVED ----------
    const editBtn = document.getElementById("editBtn");
    const deleteBtn = document.getElementById("deleteBtn");
    const reportStatusEl = document.getElementById("reportStatus");

    const reportStatus = reportStatusEl ? reportStatusEl.textContent.trim().toLowerCase() : "";

    if (reportStatus === "success" && editBtn && deleteBtn) {
        editBtn.style.display = "none";
        deleteBtn.style.display = "none";

        const actionContainer = editBtn.closest(".action-buttons");
        if (actionContainer && !actionContainer.querySelector(".resolved-badge")) {
            const badge = document.createElement("span");
            badge.className = "badge bg-success resolved-badge";
            badge.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i> Report is resolved';
            actionContainer.prepend(badge);
        }
    }
});
