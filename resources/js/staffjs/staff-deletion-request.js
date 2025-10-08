 document.addEventListener("DOMContentLoaded", function () {
        // Target all forms with confirm-form class
        document.querySelectorAll(".confirm-form").forEach(form => {
            form.addEventListener("submit", function (e) {
                e.preventDefault(); // Stop form submission

                let actionType = form.getAttribute("data-action");
                let message = actionType === "accept" 
                    ? "Are you sure you want to accept this request?" 
                    : "Are you sure you want to reject this request?";

                Swal.fire({
                    title: "Confirm Action",
                    text: message,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: actionType === "accept" ? "#2563eb" : "#dc2626",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: actionType === "accept" ? "Yes, Accept" : "Yes, Reject"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Proceed with the form
                    }
                });
            });
        });
    });