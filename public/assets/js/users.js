// Função para carregar usuários
async function loadUsers() {
    try {
        const response = await fetch(`${API_URL}/users`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const users = await response.json();
        const userTableBody = $('#userTable tbody');
        userTableBody.empty();

        users.forEach(user => {
            userTableBody.append(`
                <tr>
                    <td>${user.user_id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <button onclick="editUser(${user.user_id})">Editar</button>
                        <button onclick="deleteUser(${user.user_id})">Excluir</button>
                    </td>
                </tr>
            `);
        });
    } catch (error) {
        console.error('Erro ao carregar usuários:', error);
    }
}

// Função para carregar roles
async function loadRoles() {
    const roles = ['teacher', 'admin', 'staff', 'root']; 

    const roleSelect = $('#userRole');
    roleSelect.empty(); 

    roles.forEach(role => {
        roleSelect.append(new Option(role.charAt(0).toUpperCase() + role.slice(1), role)); // Adiciona cada role como opção
    });
}

// Função para mostrar o modal de usuário
function showUserModal() {
    loadRoles(); // Carrega as roles
    $('#userModal').show();
}

// Função para fechar o modal de usuário
function closeUserModal() {
    $('#userModal').hide();
    $('#userForm')[0].reset();
}

// Função para salvar usuário
async function saveUser() {
    const user = {
        name: $('#userName').val(),
        email: $('#userEmail').val(),
        role: $('#userRole').val(),
        password: $('#userPassword').val()
    };

    const id = $('#userId').val();
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/users/${id}` : `${API_URL}/users`;

    try {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        });

        if (response.ok) {
            closeUserModal();
            loadUsers();
        } else {
            alert('Error saving user');
        }
    } catch (error) {
        console.error('Error saving user:', error);
    }
}

// Função para editar usuário
function editUser(id) {
    fetch(`${API_URL}/${id}`)
        .then(response => response.json())
        .then(user => {
            $('#userId').val(user.user_id);
            $('#userName').val(user.name);
            $('#userEmail').val(user.email);
            $('#userRole').val(user.role);
            showUserModal();
        });
}

// Função para excluir usuário
async function deleteUser(id) {
    if (confirm('Deseja realmente excluir este usuário?')) {
        try {
            const response = await fetch(`${API_URL}/users/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                loadUsers();
            } else {
                alert('Erro ao excluir usuário');
            }
        } catch (error) {
            console.error('Erro ao excluir usuário:', error);
        }
    }
}

$(document).ready(function() {
    loadUsers();
});