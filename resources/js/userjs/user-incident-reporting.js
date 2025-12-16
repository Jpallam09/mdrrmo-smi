document.addEventListener('DOMContentLoaded', () => {
  const MAX_IMAGES = 5;
  let selectedFiles = [];
  let thumbUrls = [];
  let currentIdx = 0;

  const imageInput = document.getElementById('incident-image');
  if (!imageInput) return;

  /* ---------- Drop zone wrapper ---------- */
  const wrapper = document.createElement('div');
  wrapper.className = 'form-control shadow-sm d-flex align-items-center justify-content-center drop-zone';
  wrapper.textContent = 'Click or drag files here';
  imageInput.parentNode.insertBefore(wrapper, imageInput);
  wrapper.appendChild(imageInput); // keep input inside wrapper

  /* ---------- Drag & drop events ---------- */
  wrapper.addEventListener('dragover', e => {
    e.preventDefault();
    wrapper.classList.add('drag-over');
  });
  wrapper.addEventListener('dragleave', () => wrapper.classList.remove('drag-over'));
  wrapper.addEventListener('drop', e => {
    e.preventDefault();
    wrapper.classList.remove('drag-over');
    handleNewFiles([...e.dataTransfer.files]);
  });

  imageInput.addEventListener('change', e => handleNewFiles([...e.target.files]));

  /* ---------- Preview container ---------- */
  const previewGrid = document.createElement('previewContainer');
  previewGrid.className = 'd-flex flex-wrap gap-2 mt-2';
  wrapper.parentNode.insertBefore(previewGrid, wrapper.nextSibling);

  function handleNewFiles(files) {
    const allowed = MAX_IMAGES - selectedFiles.length;
    if (allowed <= 0) return alert(`You can only upload up to ${MAX_IMAGES} images.`);
    const toAdd = files.slice(0, allowed);
    selectedFiles.push(...toAdd);
    thumbUrls.push(...toAdd.map(f => URL.createObjectURL(f)));
    renderPreviews();
  }

function renderPreviews() {
  previewGrid.innerHTML = '';
  selectedFiles.forEach((file, idx) => {
    const item = document.createElement('div');
    item.className = 'preview-item';

    const img = document.createElement('img');
    img.src = thumbUrls[idx];
    img.alt = 'Selected image';
    img.className = 'img-thumbnail preview-img';
    img.addEventListener('click', () => openModal(idx));

    const remove = document.createElement('button');
    remove.className = 'remove-image';
    remove.innerHTML = '&times;';
    remove.addEventListener('click', () => {
      URL.revokeObjectURL(thumbUrls[idx]);
      selectedFiles.splice(idx, 1);
      thumbUrls.splice(idx, 1);
      renderPreviews();
    });

    item.append(img, remove);
    previewGrid.appendChild(item);
  });
}

  /* ---------- Modal viewer ---------- */
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');
  const closeBtn = document.getElementById('closeModal');

  const prevBtn = document.createElement('span');
  prevBtn.className = 'modal-prev';
  prevBtn.innerHTML = '&#10094;';
  const nextBtn = document.createElement('span');
  nextBtn.className = 'modal-next';
  nextBtn.innerHTML = '&#10095;';
  modal.append(prevBtn, nextBtn);

  function showImage(idx) {
    if (!thumbUrls.length) return;
    currentIdx = (idx + thumbUrls.length) % thumbUrls.length;
    modalImg.src = thumbUrls[currentIdx];
  }

  function openModal(idx) {
    showImage(idx);
    modal.classList.add('open');
  }

  function hideModal() {
    modal.classList.remove('open');
  }

  closeBtn?.addEventListener('click', hideModal);
  modal.addEventListener('click', e => { if (e.target === modal) hideModal(); });

  prevBtn.addEventListener('click', e => { e.stopPropagation(); showImage(currentIdx - 1); });
  nextBtn.addEventListener('click', e => { e.stopPropagation(); showImage(currentIdx + 1); });

  document.addEventListener('keydown', e => {
    if (!modal.classList.contains('open')) return;
    if (e.key === 'Escape') hideModal();
    if (e.key === 'ArrowLeft') showImage(currentIdx - 1);
    if (e.key === 'ArrowRight') showImage(currentIdx + 1);
  });
});
