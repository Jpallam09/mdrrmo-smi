document.addEventListener('DOMContentLoaded', () => {
    const resetBtn = document.getElementById('resetButton');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const coordsHelp = document.getElementById('coordsHelpPreview');
    const map = L.map('mapPreview').setView([16.88122, 121.5878223], 13);

    // Add map tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    // Function to update marker and inputs
    function updateLocation(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                const { lat, lng } = e.target.getLatLng();
                latInput.value = lat;
                lngInput.value = lng;
                coordsHelp.textContent = `Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`;
            });
        }
        map.setView([lat, lng], 15);
        latInput.value = lat;
        lngInput.value = lng;
        coordsHelp.textContent = `Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`;

        // Show reset button
        resetBtn.classList.remove("d-none");
    }

    // "Use My Location" button
    document.getElementById('locateBtn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    updateLocation(latitude, longitude);
                },
                () => alert('Unable to get your location. Please allow location access.')
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });

    // Click map to choose location
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        updateLocation(lat, lng);
    });

    // Reset button clears everything
    resetBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }
        latInput.value = "";
        lngInput.value = "";
        coordsHelp.textContent = "No location selected.";

        // Hide reset button again
        resetBtn.classList.add("d-none");
    });

    // If editing and coords exist → show location + reset button
    if (latInput.value && lngInput.value) {
        updateLocation(parseFloat(latInput.value), parseFloat(lngInput.value));
    }
});
