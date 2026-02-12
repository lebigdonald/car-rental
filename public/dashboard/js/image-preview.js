document.addEventListener('DOMContentLoaded', function() {
    // Function to preview main image
    const mainImageInput = document.getElementById('main_image');
    const mainImagePreviewContainer = document.getElementById('main_image_preview');

    if (mainImageInput && mainImagePreviewContainer) {
        mainImageInput.addEventListener('change', function(event) {
            mainImagePreviewContainer.innerHTML = ''; // Clear previous preview
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxHeight = '200px';
                    img.style.marginTop = '10px';
                    img.classList.add('img-fluid');
                    mainImagePreviewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Function to preview secondary images
    const secondaryImagesInput = document.getElementById('secondary_images');
    const secondaryImagesPreviewContainer = document.getElementById('secondary_images_preview');

    if (secondaryImagesInput && secondaryImagesPreviewContainer) {
        secondaryImagesInput.addEventListener('change', function(event) {
            secondaryImagesPreviewContainer.innerHTML = ''; // Clear previous previews
            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxHeight = '100px';
                        img.style.marginRight = '10px';
                        img.style.marginTop = '10px';
                        img.classList.add('img-thumbnail');
                        secondaryImagesPreviewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    }
});
