document.addEventListener('DOMContentLoaded', () => {
    console.log("🔔 Notification sound system initialized.");

    // ✅ Automatically detect base URL for both localhost and production
    let baseUrl = window.location.origin;
    if (window.location.pathname.includes('/mdrrmo/public')) {
        baseUrl += '/mdrrmo/public';
    }

    // ✅ Correct sound path
    const audio = new Audio(`${baseUrl}/sounds/notify.wav`);
    let lastCount = 0;

    async function checkNewReports() {
        try {
            
            const response = await fetch(`${baseUrl}/incidentReporting/staffReporting/check-new-reports`);
            const data = await response.json();

            console.log("📦 Report count:", data.count);

            if (lastCount !== 0 && data.count > lastCount) {
                console.log("🎶 New report detected!");
                audio.play().catch(err => console.warn("Audio blocked:", err));
            }

            lastCount = data.count;
        } catch (error) {
            console.error("Error checking new reports:", error);
        }
    }

    checkNewReports();
    setInterval(checkNewReports, 5000);
});
