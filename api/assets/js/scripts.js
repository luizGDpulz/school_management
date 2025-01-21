async function fetchUsers() {
    try {
        const response = await fetch('http://localhost/api/users'); // Altere a URL conforme necessário
        const users = await response.json();
        const userTable = document.getElementById('userTable');

        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="py-2 px-4 border-b">${user.user_id}</td>
                <td class="py-2 px-4 border-b">${user.name}</td>
                <td class="py-2 px-4 border-b">${user.email}</td>
                <td class="py-2 px-4 border-b">${user.role}</td>
            `;
            userTable.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

// Call the function to fetch users when the page loads
window.onload = fetchUsers;
