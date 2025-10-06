document.addEventListener('DOMContentLoaded', () => {
  const viewButtons = document.querySelectorAll('.btn-view-request');
  const acceptButtons = document.querySelectorAll('.btn-accept');
  const rejectButtons = document.querySelectorAll('.btn-reject');

  // Handle View Button & Modal
  viewButtons.forEach(button => {
    const requestId = button.dataset.requestId;
    const modal = document.getElementById(`viewEditRequestModal-${requestId}`);
    if (!modal) return;

    const closeButton = modal.querySelector('.edit-request-close');

    // Open modal
    button.addEventListener('click', () => {
      modal.classList.add('active');
      document.body.classList.add('no-scroll');
    });

    // Close modal via X button
    closeButton?.addEventListener('click', () => {
      modal.classList.remove('active');
      document.body.classList.remove('no-scroll');
    });

    // Close modal via clicking outside the dialog
    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        modal.classList.remove('active');
        document.body.classList.remove('no-scroll');
      }
    });
  });

  // ✅ Accept Button with SweetAlert (now matches reject logic)
  acceptButtons.forEach(button => {
    button.addEventListener('click', (event) => {
      event.preventDefault(); // 🔧 added to prevent default submission

      const requestId = getRequestIdFromModal(button);
      if (!requestId) return;

      Swal.fire({
        title: 'Accept Edit Request?',
        text: "This action will approve the requested changes.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.querySelector(`#viewEditRequestModal-${requestId} .form-accept`);
          if (form) form.submit();
        }
      });
    });
  });

  // ✅ Reject Button with SweetAlert
  rejectButtons.forEach(button => {
    button.addEventListener('click', (event) => {
      event.preventDefault();

      const requestId = getRequestIdFromModal(button);
      if (!requestId) return;

      Swal.fire({
        title: 'Reject Edit Request?',
        text: "This will decline the requested changes.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#2563eb',
        confirmButtonText: 'Yes, Reject',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.querySelector(`#viewEditRequestModal-${requestId} .form-reject`);
          if (form) form.submit();
        }
      });
    });
  });

  // Helper: Get request ID from modal ID
  function getRequestIdFromModal(button) {
    const modal = button.closest('.edit-request-modal');
    const idMatch = modal?.id.match(/viewEditRequestModal-(\d+)/);
    return idMatch ? idMatch[1] : null;
  }
});
