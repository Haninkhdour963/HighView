function handleFilesProduct(files, previewId) {
  const preview = document.getElementById(previewId);
  preview.innerHTML = ""; // Clear existing preview

  if (files.length > 0) {
    const img = document.createElement("img");
    img.src = URL.createObjectURL(files[0]);
    img.className = "img-thumbnail";
    img.style.maxWidth = "100px";
    img.style.height = "50px";
    img.onload = () => URL.revokeObjectURL(img.src); // Clean up memory
    preview.appendChild(img);
  }
}

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

function setupDragAndDrop(areaId, inputFile, previewId) {
  const dropArea = document.getElementById(areaId);
  const input = document.querySelector(`input[name="${inputFile}"]`);

  dropArea.addEventListener("dragover", (event) => {
    event.preventDefault();
    dropArea.classList.add("dragging"); // Add a class for visual feedback if desired
  });

  dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("dragging");
  });

  dropArea.addEventListener("drop", (event) => {
    event.preventDefault();
    dropArea.classList.remove("dragging");

    const files = event.dataTransfer.files;
    if (files.length > 0) {
      input.files = files; // Assign files to input
      handleFilesProduct(files, previewId); // Preview the file
    }
  });
}

// Initialize drag-and-drop areas after DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  setupDragAndDrop("front-drop-area", "front_view", "front-preview");
  setupDragAndDrop("side-drop-area", "side_view", "side-preview");
  setupDragAndDrop("back-drop-area", "back_view", "back-preview");
});

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
  "use strict";
  const forms = document.querySelectorAll(".needs-validation");
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();
