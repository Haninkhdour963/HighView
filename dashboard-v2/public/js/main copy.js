function handleFiles(files) {
  const file = files[0]; // Get the first file
  if (file) {
    const preview = document.getElementById("preview");
    const imgPathInput = document.getElementById("img");

    // Create a preview of the image
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.innerHTML =
        '<img src="' +
        e.target.result +
        '" alt="Image Preview" style="max-width: 100%; height: auto;">';
    };
    reader.readAsDataURL(file);

    // Set the img input value to the file name (or you can set the path if needed)
    imgPathInput.value = file.name; // Store the file name for the backend processing
  }
}

function handleDrop(event) {
  event.preventDefault();
  const files = event.dataTransfer.files;
  handleFiles(files);
}

// JS for coupon

// Enhanced alert animation
const alert = document.getElementById("alert");
if (alert) {
  setTimeout(() => {
    alert.classList.add("slide-out");
    setTimeout(() => {
      alert.style.display = "none";
    }, 300);
  }, 3000);
}

// Form validation
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
