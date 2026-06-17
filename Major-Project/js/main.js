// main.js

// Example of form validation for the Add Pet form
document.addEventListener("DOMContentLoaded", function () {
    const addPetForm = document.querySelector('form');
    if (addPetForm) {
        addPetForm.addEventListener('submit', function (event) {
            const petname = document.getElementById('petname').value;
            const age = document.getElementById('age').value;

            if (!petname || petname.length < 3) {
                alert('Pet name must be at least 3 characters long.');
                event.preventDefault();
            }

            if (!age || age <= 0) {
                alert('Please enter a valid age.');
                event.preventDefault();
            }
        });
    }

    // Example: Display a message in the console when an image is clicked
    const images = document.querySelectorAll('img');
    images.forEach(image => {
        image.addEventListener('click', function () {
            console.log('Image clicked: ' + image.alt);
        });
    });
});
