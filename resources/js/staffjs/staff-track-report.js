document.addEventListener("DOMContentLoaded", () => {
    const reportId = document.querySelector("input[name='report_id']").value;
    const incidentLatValue = document.getElementById("incidentLat").value;
    const incidentLngValue = document.getElementById("incidentLng").value;
    const trackUrl = document.getElementById("trackUrlContainer").dataset.trackUrl;

    // Custom icons
    const redIcon = L.icon({
        iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png",
        shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
    });

    const blueIcon = L.icon({
        iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png",
        shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
    });

    // Initialize map only if coordinates exist
    let map = null;
    let routingControl = null;
    let distanceDiv = null;
    let incidentLat = null;
    let incidentLng = null;

    if (incidentLatValue && incidentLngValue) {
        incidentLat = parseFloat(incidentLatValue);
        incidentLng = parseFloat(incidentLngValue);

        map = L.map("map").setView([incidentLat, incidentLng], 15);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors",
        }).addTo(map);

        // Incident marker + circle
        L.marker([incidentLat, incidentLng], { icon: redIcon })
            .addTo(map)
            .bindPopup("Incident Location")
            .openPopup();

        L.circle([incidentLat, incidentLng], {
            radius: 30,
            color: "red",
            fillColor: "#f03",
            fillOpacity: 0.2,
        }).addTo(map);

        // Routing
        routingControl = L.Routing.control({
            waypoints: [L.latLng(incidentLat, incidentLng), L.latLng(incidentLat, incidentLng)],
            lineOptions: { styles: [{ color: "blue", opacity: 0.7, weight: 5 }] },
            createMarker: () => null,
            addWaypoints: false,
            routeWhileDragging: false,
        }).addTo(map);

        // Distance display
        distanceDiv = document.createElement("div");
        distanceDiv.id = "distanceInfo";
        distanceDiv.style.textAlign = "center";
        distanceDiv.style.marginBottom = "10px";
        map.getContainer().parentNode.insertBefore(distanceDiv, map.getContainer().nextSibling);
    }

    let staffMarker = null;
    let lastCoords = null;
    const minDistance = 5; // meters
    const updateInterval = 2000; // 2s
    let lastUpdateTime = 0;

    function shouldUpdate(lat, lng) {
        const now = Date.now();
        if (now - lastUpdateTime < updateInterval) return false;
        lastUpdateTime = now;

        if (!lastCoords) {
            lastCoords = [lat, lng];
            return true;
        }
        if (!map) return true; // If no map, just update
        const distance = map.distance(lastCoords, [lat, lng]);
        if (distance >= minDistance) {
            lastCoords = [lat, lng];
            return true;
        }
        return false;
    }

    function showMessage(message, color = "red") {
        const msgDiv = document.getElementById("responseMessage");
        msgDiv.textContent = message;
        msgDiv.style.color = color;
    }

    document.querySelector("#trackReportForm").addEventListener("submit", function (e) {
        e.preventDefault();
        if (!navigator.geolocation) return showMessage("Geolocation not supported.");

        navigator.geolocation.watchPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (!shouldUpdate(lat, lng)) return;

                // Staff marker
                if (map) {
                    if (!staffMarker) {
                        staffMarker = L.marker([lat, lng], { icon: blueIcon })
                            .addTo(map)
                            .bindPopup("Staff Location")
                            .openPopup();
                    } else {
                        staffMarker.setLatLng([lat, lng]);
                    }

                    // Routing & distance
                    routingControl.setWaypoints([L.latLng(incidentLat, incidentLng), L.latLng(lat, lng)]);
                    const dist = map.distance([lat, lng], [incidentLat, incidentLng]);
                    distanceDiv.textContent = `Distance to incident: ${dist.toFixed(0)} m`;
                }

                // Update coordinates
                document.getElementById("currentLat").textContent = lat.toFixed(6);
                document.getElementById("currentLng").textContent = lng.toFixed(6);

                // Send to server
                fetch(trackUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({ report_id: reportId, latitude: lat, longitude: lng }),
                })
                    .then((res) => res.json())
                    .then((data) => showMessage(data.success ? "Location updated." : "Failed to update location.", data.success ? "green" : "red"))
                    .catch((err) => {
                        console.error(err);
                        showMessage("Error sending location.");
                    });
            },
            (err) => {
                console.error(err);
                if (err.code === 3) showMessage("Location timeout. Try moving a bit or refresh.");
                else showMessage("Unable to retrieve location.");
            },
            { enableHighAccuracy: true, maximumAge: 0, timeout: 30000 }
        );
    });

    // Success button
    document.querySelectorAll(".btn-success-track").forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.dataset.id;
            Swal.fire({
                title: "Mark as Success?",
                text: "This will mark the report as successfully resolved.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, success",
                cancelButtonText: "No, cancel",
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`successForm-${id}`);
                    if (form) form.submit();
                }
            });
        });
    });

    // Cancel button
    document.querySelectorAll(".btn-cancel-track").forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.dataset.id;
            Swal.fire({
                title: "Cancel this report?",
                text: "This will mark the report as canceled.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, cancel it",
                cancelButtonText: "No, keep it",
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`cancelForm-${id}`);
                    if (form) form.submit();
                }
            });
        });
    });
});
