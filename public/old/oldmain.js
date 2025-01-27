const API_URL = 'http://localhost/api'; // Define the API URL

const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text"),
      header = body.querySelector(".header"),
      sections = document.querySelectorAll('.content-section'); // Seleciona todas as seções

toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close"); // Toggle sidebar visibility
    header.classList.toggle("close"); // Adjust header when sidebar is toggled
});

toggle.addEventListener("click", () => {
  searchBtn.classList.remove("close");
});

modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark"); // Toggle dark mode
    modeText.innerText = body.classList.contains("dark") ? "Light Mode" : "Dark Mode"; // Update mode text
});

async function loadReservations() {
    const response = await fetch(`${API_URL}/users`); // Fetch reservations from API
    const data = await response.json(); // Parse JSON response
    $('#dataField').html(JSON.stringify(data)); // Display data in the dashboard content
}

// Handle form submission
document.getElementById("formData").addEventListener("submit", async (event) => {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(event.target); // Get form data
    const data = Object.fromEntries(formData.entries()); // Convert form data to an object

    // Send data to the API
    await fetch(`${API_URL}/register`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data), // Send data as JSON
    });

    // Clear the form and reload reservations
    event.target.reset(); // Reset form fields
    loadReservations(); // Reload reservations
});

// Função genérica para alternar entre seções
function toggleSection(showElementId) {
    sections.forEach(section => {
        section.style.display = section.id === showElementId ? 'block' : 'none'; // Exibe a seção correspondente e oculta as outras
    });
}

// Adicionando evento de clique aos links da sidebar
document.querySelector(".toggle-dashboard").addEventListener("click", () => {
    toggleSection('dashboard'); // Alterna para o Dashboard
});

document.querySelector(".toggle-infrastructure").addEventListener("click", () => {
    toggleSection('infrastructure'); // Alterna para Infrastructure
});

document.querySelector(".toggle-resources").addEventListener("click", () => {
    toggleSection('resources'); // Alterna para Resources
});

document.querySelector(".toggle-users").addEventListener("click", () => {
    toggleSection('users'); // Alterna para Users
});

document.querySelector(".toggle-class").addEventListener("click", () => {
    toggleSection('class'); // Alterna para Class
});

document.querySelector(".toggle-notifications").addEventListener("click", () => {
    toggleSection('notifications'); // Alterna para Notifications
});

// Inicializa exibindo o Dashboard
document.addEventListener("DOMContentLoaded", () => {
    toggleSection('dashboard'); // Exibe o Dashboard ao carregar a página
});

$(document).ready(function() {
    loadReservations(); // Load reservations on page ready
}); 