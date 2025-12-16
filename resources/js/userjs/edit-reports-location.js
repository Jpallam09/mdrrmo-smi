document.addEventListener('DOMContentLoaded', () => {
    // Get DOM elements
    const mapControls = document.getElementById('mapControls');
    const mapPreview = document.getElementById('mapPreview');
    const coordsHelp = document.getElementById('coordsHelpPreview');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const locateBtn = document.getElementById('locateBtn');
    const resetBtn = document.getElementById('resetButton');

    // Parse initial coordinates
    const initialLat = parseFloat(latitudeInput.value);
    const initialLng = parseFloat(longitudeInput.value);

    // Initialize maps
    const controlsMap = L.map(mapControls).setView(
        initialLat && initialLng ? [initialLat, initialLng] : [14.5995, 120.9842],
        initialLat && initialLng ? 15 : 13
    );
    const previewMap = L.map(mapPreview).setView(
        initialLat && initialLng ? [initialLat, initialLng] : [14.5995, 120.9842],
        initialLat && initialLng ? 15 : 13
    );

    // Add tiles
    [controlsMap, previewMap].forEach(m => {
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(m);
    });

    let markerControls, markerPreview;

    // Update markers and inputs
    const updateLocation = (lat, lng) => {
        latitudeInput.value = lat;
        longitudeInput.value = lng;

        if (markerControls) {
            markerControls.setLatLng([lat, lng]);
        } else {
            markerControls = L.marker([lat, lng], { draggable: true }).addTo(controlsMap);
            markerControls.on('dragend', (e) => {
                const { lat, lng } = e.target.getLatLng();
                updateLocation(lat, lng);
            });
        }

        if (markerPreview) {
            markerPreview.setLatLng([lat, lng]);
        } else {
            markerPreview = L.marker([lat, lng]).addTo(previewMap);
        }

        previewMap.setView([lat, lng], 15);
        coordsHelp.textContent = `Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`;

        // ✅ Show reset button
        resetBtn.classList.remove('d-none');
    };

    // If location already exists, show it
    if (initialLat && initialLng) {
        updateLocation(initialLat, initialLng);
        resetBtn.classList.remove('d-none');
    } else {
        coordsHelp.textContent = "No location provided";
    }

    // Use My Location
    locateBtn.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }
        navigator.geolocation.getCurrentPosition(
            (position) => {
                updateLocation(position.coords.latitude, position.coords.longitude);
                controlsMap.setView([position.coords.latitude, position.coords.longitude], 15);
            },
            () => {
                alert('Unable to get your location. Please allow location access.');
            }
        );
    });

    // ✅ Reset button functionality
    resetBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (markerControls) {
            controlsMap.removeLayer(markerControls);
            markerControls = null;
        }
        if (markerPreview) {
            previewMap.removeLayer(markerPreview);
            markerPreview = null;
        }

        latitudeInput.value = "";
        longitudeInput.value = "";
        coordsHelp.textContent = "No location provided";

        controlsMap.setView([14.5995, 120.9842], 13);
        previewMap.setView([14.5995, 120.9842], 13);

        resetBtn.classList.add('d-none'); // 👈 Hide again
    });
});
