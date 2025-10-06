document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('profilePictureInput');
    const img = document.getElementById('profilePicture');
    const resetBtn = document.getElementById('resetProfilePicture');

    const defaultSrc = img.getAttribute('data-default');

    // Preview when file is selected
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                resetBtn.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Reset to original picture
    resetBtn.addEventListener('click', function () {
        img.src = defaultSrc;
        input.value = ''; // clear file selection
        resetBtn.classList.add('d-none');
    });
});
