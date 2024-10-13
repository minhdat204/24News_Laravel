// Select the toggle button
const toggleButton = document.getElementById('toggle-dark-mode');

// Add an event listener to toggle dark mode
toggleButton.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
});
