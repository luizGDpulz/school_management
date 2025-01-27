document.addEventListener("DOMContentLoaded", () => {
    const formContainer = document.getElementById('formContainer');
    const dataTableContainer = document.getElementById('dataTableContainer');

    // Função para exibir o formulário e a tabela
    function showFormAndTable(type) {
        formContainer.innerHTML = ''; // Limpa o contêiner do formulário
        dataTableContainer.innerHTML = ''; // Limpa o contêiner da tabela

        let formHTML = createFormHTML(type);
        formContainer.innerHTML = formHTML;

        // Adiciona eventos para os botões de adicionar
        addEventListeners(type);
    }

    // Função para criar o HTML do formulário
    function createFormHTML(type) {
        if (type === 'buildings') {
            return `
                <h3>Add Building</h3>
                <input type="text" id="buildingName" placeholder="Building Name" required>
                <input type="text" id="buildingAddress" placeholder="Address" required>
                <input type="number" id="buildingFloors" placeholder="Number of Floors" required>
                <input type="text" id="buildingColor" placeholder="Color ID" required>
                <button id="addBuilding">Add Building</button>
            `;
        } else if (type === 'rooms') {
            return `
                <h3>Add Room</h3>
                <input type="text" id="roomName" placeholder="Room Name" required>
                <input type="number" id="roomCapacity" placeholder="Capacity" required>
                <input type="text" id="roomType" placeholder="Room Type ID" required>
                <input type="text" id="roomColor" placeholder="Color ID" required>
                <button id="addRoom">Add Room</button>
            `;
        } else if (type === 'floors') {
            return `
                <h3>Add Floor</h3>
                <input type="text" id="floorName" placeholder="Floor Name" required>
                <input type="number" id="floorRooms" placeholder="Number of Rooms" required>
                <input type="text" id="floorBuilding" placeholder="Building ID" required>
                <input type="text" id="floorColor" placeholder="Color ID" required>
                <button id="addFloor">Add Floor</button>
            `;
        }
    }

    // Função para adicionar eventos aos botões
    function addEventListeners(type) {
        if (type === 'buildings') {
            document.getElementById('addBuilding').addEventListener('click', addBuilding);
            fetchBuildings(); // Carrega os dados existentes
        } else if (type === 'rooms') {
            document.getElementById('addRoom').addEventListener('click', addRoom);
            fetchRooms(); // Carrega os dados existentes
        } else if (type === 'floors') {
            document.getElementById('addFloor').addEventListener('click', addFloor);
            fetchFloors(); // Carrega os dados existentes
        }
    }

    // Funções para adicionar, atualizar e deletar
    function addBuilding() {
        const buildingData = {
            name: document.getElementById('buildingName').value,
            address: document.getElementById('buildingAddress').value,
            floors_number: document.getElementById('buildingFloors').value,
            color_id: document.getElementById('buildingColor').value
        };
        sendData(`${API_URL}/buildings`, 'POST', buildingData, fetchBuildings);
    }

    function addRoom() {
        const roomData = {
            name: document.getElementById('roomName').value,
            capacity: document.getElementById('roomCapacity').value,
            type: document.getElementById('roomType').value,
            color_id: document.getElementById('roomColor').value
        };
        sendData(`${API_URL}/rooms`, 'POST', roomData, fetchRooms);
    }

    function addFloor() {
        const floorData = {
            name: document.getElementById('floorName').value,
            rooms_number: document.getElementById('floorRooms').value,
            building_id: document.getElementById('floorBuilding').value,
            color_id: document.getElementById('floorColor').value
        };
        sendData(`${API_URL}/floors`, 'POST', floorData, fetchFloors);
    }

    // Função para enviar dados para a API
    function sendData(url, method, data, callback) {
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            callback(); // Atualiza a tabela
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add item. Please try again.');
        });
    }

    function fetchBuildings() {
        fetch(`${API_URL}/buildings`)
            .then(response => response.json())
            .then(data => {
                renderTable(data, 'buildings');
            });
    }

    function fetchRooms() {
        fetch(`${API_URL}/rooms`)
            .then(response => response.json())
            .then(data => {
                renderTable(data, 'rooms');
            });
    }

    function fetchFloors() {
        fetch(`${API_URL}/floors`)
            .then(response => response.json())
            .then(data => {
                renderTable(data, 'floors');
            });
    }

    function renderTable(data, type) {
        let tableHTML = `<table><tr><th>ID</th><th>Name</th><th>Actions</th></tr>`;
        data.forEach(item => {
            if (type === 'buildings') {
                tableHTML += `
                    <tr>
                        <td>${item.building_id}</td>
                        <td>${item.name}</td>
                        <td>
                            <button onclick="editBuilding(${item.building_id})">Edit</button>
                            <button onclick="deleteBuilding(${item.building_id})">Delete</button>
                        </td>
                    </tr>
                `;
            } else if (type === 'rooms') {
                tableHTML += `
                    <tr>
                        <td>${item.room_id}</td>
                        <td>${item.name}</td>
                        <td>
                            <button onclick="editRoom(${item.room_id})">Edit</button>
                            <button onclick="deleteRoom(${item.room_id})">Delete</button>
                        </td>
                    </tr>
                `;
            } else if (type === 'floors') {
                tableHTML += `
                    <tr>
                        <td>${item.floor_id}</td>
                        <td>${item.name}</td>
                        <td>
                            <button onclick="editFloor(${item.floor_id})">Edit</button>
                            <button onclick="deleteFloor(${item.floor_id})">Delete</button>
                        </td>
                    </tr>
                `;
            }
        });
        tableHTML += `</table>`;
        dataTableContainer.innerHTML = tableHTML;
    }

    // Funções para editar e deletar
    window.editBuilding = function(building_id) {
        // Implementar lógica de edição
        const name = prompt("Enter new name:");
        const address = prompt("Enter new address:");
        const floors_number = prompt("Enter new number of floors:");
        const color_id = prompt("Enter new color ID:");

        fetch(`${API_URL}/buildings/${building_id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, address, floors_number, color_id })
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchBuildings(); // Atualiza a tabela
        });
    };

    window.deleteBuilding = function(building_id) {
        fetch(`${API_URL}/buildings/${building_id}`, {
            method: 'DELETE'
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchBuildings(); // Atualiza a tabela
        });
    };

    window.editRoom = function(room_id) {
        // Implementar lógica de edição
        const name = prompt("Enter new name:");
        const capacity = prompt("Enter new capacity:");
        const type = prompt("Enter new room type ID:");
        const color_id = prompt("Enter new color ID:");

        fetch(`${API_URL}/rooms/${room_id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, capacity, type, color_id })
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchRooms(); // Atualiza a tabela
        });
    };

    window.deleteRoom = function(room_id) {
        fetch(`${API_URL}/rooms/${room_id}`, {
            method: 'DELETE'
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchRooms(); // Atualiza a tabela
        });
    };

    window.editFloor = function(floor_id) {
        // Implementar lógica de edição
        const name = prompt("Enter new name:");
        const rooms_number = prompt("Enter new number of rooms:");
        const building_id = prompt("Enter new building ID:");
        const color_id = prompt("Enter new color ID:");

        fetch(`${API_URL}/floors/${floor_id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, rooms_number, building_id, color_id })
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchFloors(); // Atualiza a tabela
        });
    };

    window.deleteFloor = function(floor_id) {
        fetch(`${API_URL}/floors/${floor_id}`, {
            method: 'DELETE'
        }).then(response => response.json()).then(data => {
            alert(data.message);
            fetchFloors(); // Atualiza a tabela
        });
    };

    // Eventos para os botões do menu
    document.getElementById('showBuildings').addEventListener('click', () => showFormAndTable('buildings'));
    document.getElementById('showRooms').addEventListener('click', () => showFormAndTable('rooms'));
    document.getElementById('showFloors').addEventListener('click', () => showFormAndTable('floors'));
}); 