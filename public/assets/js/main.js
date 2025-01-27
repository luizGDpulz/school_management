const API_URL = 'http://localhost/api';

const body = document.querySelector("body"),
      sidebar = body.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text"),
      header = body.querySelector(".header"),
      headerTitle = document.querySelector(".header-title"), // Seleciona o título do header
      sections = document.querySelectorAll('.content-section'); // Seleciona todas as seções


toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close"); // Toggle sidebar visibility
    header.classList.toggle("close"); // Adjust header when sidebar is toggled
});

modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark"); // Toggle dark mode
    modeText.innerText = body.classList.contains("dark") ? "Light Mode" : "Dark Mode"; // Update mode text
});

// Função genérica para alternar entre seções
function toggleSection(showElementId, title) {
    sections.forEach(section => {
        section.style.display = section.id === showElementId ? 'block' : 'none'; // Exibe a seção correspondente e oculta as outras
    });
    headerTitle.textContent = title; // Atualiza o título do header
}

// Adicionando evento de clique aos links da sidebar
document.querySelector(".toggle-dashboard").addEventListener("click", () => {
    toggleSection('dashboard', 'Dashboard'); // Alterna para o Dashboard e atualiza o título
});

document.querySelector(".toggle-infrastructure").addEventListener("click", () => {
    toggleSection('infrastructure', 'Infrastructure'); // Alterna para Infrastructure e atualiza o título
});

document.querySelector(".toggle-resources").addEventListener("click", () => {
    toggleSection('resources', 'Resources'); // Alterna para Resources e atualiza o título
});

document.querySelector(".toggle-users").addEventListener("click", () => {
    toggleSection('users', 'Users'); // Alterna para Users e atualiza o título
});

document.querySelector(".toggle-class").addEventListener("click", () => {
    toggleSection('class', 'Class'); // Alterna para Class e atualiza o título
});

document.querySelector(".toggle-notifications").addEventListener("click", () => {
    toggleSection('notifications', 'Notifications'); // Alterna para Notifications e atualiza o título
});

// Inicializa exibindo o Dashboard
document.addEventListener("DOMContentLoaded", () => {
    toggleSection('dashboard', 'Dashboard'); // Exibe o Dashboard ao carregar a página e atualiza o título
});