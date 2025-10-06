import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const { originalLat, originalLng, requestedLat, requestedLng } =
        window.reportData || {};

    // ---- Original location map ----
    if (originalLat && originalLng) {
        const originalMap = L.map("originalMap", {
            zoomControl: false, // remove + / - buttons
            dragging: false, // disable dragging
            scrollWheelZoom: false, // disable scroll zoom
            doubleClickZoom: false, // disable double click zoom
            boxZoom: false, // disable shift+drag zoom
            keyboard: false, // disable keyboard controls
            touchZoom: false, // disable pinch zoom on mobile
        }).setView([originalLat, originalLng], 14); // fixed zoom level (14)

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(originalMap);

        L.marker([originalLat, originalLng]).addTo(originalMap);
    }

    // ---- Requested location map ----
    if (requestedLat && requestedLng) {
        const requestedMap = L.map("requestedMap", {
            zoomControl: false, // remove + / - buttons
            dragging: false, // disable dragging
            scrollWheelZoom: false, // disable scroll zoom
            doubleClickZoom: false, // disable double click zoom
            boxZoom: false, // disable shift+drag zoom
            keyboard: false, // disable keyboard controls
            touchZoom: false, // disable pinch zoom on mobile
        }).setView([requestedLat, requestedLng], 14); // fixed zoom level (14)

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(requestedMap);

        L.marker([requestedLat, requestedLng]).addTo(requestedMap);
    }

    // ---- Confirm before accept/reject ----
    const forms = document.querySelectorAll(".confirm-form");
    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const isAccept = form
                .querySelector("button")
                .classList.contains("btn-success");
            const actionText = isAccept ? "accept" : "reject";
            const confirmButtonColor = isAccept ? "#28a745" : "#dc2626";

            Swal.fire({
                title: "Are you sure?",
                text: `You are about to ${actionText} this edit request.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor,
                cancelButtonColor: "#6c757d",
                confirmButtonText: `Yes, ${actionText} it!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
