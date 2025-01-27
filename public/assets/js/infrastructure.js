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

    // ==========================
    // Funções para Gerenciar Edifícios, Andares e Salas
    // ==========================

    // Função genérica para carregar dados de uma tabela
    async function loadData(url, tableBodyId) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Failed to load data from ${url}`);
            const data = await response.json();
            const tableBody = $(tableBodyId);
            tableBody.empty();

            data.forEach(item => {
                const row = createRow(item);
                tableBody.append(row);
            });
        } catch (error) {
            console.error(error);
            alert(error.message);
        }
    }

    // Função para criar uma linha na tabela de edifícios
    function createRow(building) {
        return `
            <tr>
                <td>${building.building_id}</td>
                <td>${building.name}</td>
                <td>${building.address}</td>
                <td>${building.floors_number}</td>
                <td>
                    <button onclick="editBuilding(${building.building_id})">Edit</button>
                    <button onclick="deleteBuilding(${building.building_id})">Delete</button>
                </td>
            </tr>
        `;
    }

    // Função para carregar edifícios
    async function loadBuildings() {
        await loadData(`${API_URL}/buildings`, '#buildingTable tbody');
    }

    // Função para carregar andares
    async function loadFloors() {
        await loadData(`${API_URL}/floors`, '#floorTable tbody');
    }

    // Função para carregar salas
    async function loadRooms() {
        await loadData(`${API_URL}/rooms`, '#roomTable tbody');
    }

    // Função genérica para salvar dados
    async function saveData(url, data, modalCloseFunction) {
        const method = data.id ? 'PUT' : 'POST';
        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error(`Failed to save data to ${url}`);
            modalCloseFunction();
            loadData(url.replace(/\/[^/]+$/, ''), `#${url.split('/').pop()}Table tbody`); // Atualiza a tabela correspondente
        } catch (error) {
            console.error(error);
            alert(error.message);
        }
    }

    // Função para salvar edifício
    async function saveBuilding() {
        const building = {
            id: $('#buildingId').val(),
            name: $('#buildingName').val(),
            address: $('#buildingAddress').val(),
            floors_number: $('#buildingFloors').val(),
            color_id: $('#buildingColorId').val()
        };
        await saveData(`${API_URL}/buildings`, building, closeBuildingModal);
    }

    // Função para salvar andar
    async function saveFloor() {
        const floor = {
            id: $('#floorId').val(),
            building_id: $('#floorBuildingId').val(),
            floor_number: $('#floorNumber').val()
        };
        await saveData(`${API_URL}/floors`, floor, closeFloorModal);
    }

    // Função para salvar sala
    async function saveRoom() {
        const room = {
            id: $('#roomId').val(),
            floor_id: $('#roomFloorId').val(),
            name: $('#roomName').val(),
            capacity: $('#roomCapacity').val()
        };
        await saveData(`${API_URL}/rooms`, room, closeRoomModal);
    }

    // Função genérica para editar dados
    function editData(url, id, modalShowFunction, modalDataFunction) {
        fetch(`${url}/${id}`)
            .then(response => {
                if (!response.ok) throw new Error(`Failed to load data from ${url}`);
                return response.json();
            })
            .then(data => {
                modalDataFunction(data);
                modalShowFunction();
            })
            .catch(error => {
                console.error(error);
                alert(error.message);
            });
    }

    // Função para editar edifício
    function editBuilding(id) {
        editData(`${API_URL}/buildings`, id, () => $('#buildingModal').show(), (building) => {
            $('#buildingId').val(building.building_id);
            $('#buildingName').val(building.name);
            $('#buildingAddress').val(building.address);
            $('#buildingFloors').val(building.floors_number);
            $('#buildingColorId').val(building.color_id);
        });
    }

    // Função para editar andar
    function editFloor(id) {
        editData(`${API_URL}/floors`, id, () => $('#floorModal').show(), (floor) => {
            $('#floorId').val(floor.floor_id);
            $('#floorBuildingId').val(floor.building_id);
            $('#floorNumber').val(floor.floor_number);
        });
    }

    // Função para editar sala
    function editRoom(id) {
        editData(`${API_URL}/rooms`, id, () => $('#roomModal').show(), (room) => {
            $('#roomId').val(room.room_id);
            $('#roomFloorId').val(room.floor_id);
            $('#roomName').val(room.name);
            $('#roomCapacity').val(room.capacity);
        });
    }

    // Função genérica para excluir dados
    async function deleteData(url, id, loadFunction) {
        if (confirm('Do you really want to delete this item?')) {
            try {
                const response = await fetch(`${url}/${id}`, {
                    method: 'DELETE'
                });

                if (!response.ok) throw new Error(`Failed to delete data from ${url}`);
                loadFunction();
            } catch (error) {
                console.error(error);
                alert(error.message);
            }
        }
    }

    // Função para excluir edifício
    async function deleteBuilding(id) {
        await deleteData(`${API_URL}/buildings`, id, loadBuildings);
    }

    // Função para excluir andar
    async function deleteFloor(id) {
        await deleteData(`${API_URL}/floors`, id, loadFloors);
    }

    // Função para excluir sala
    async function deleteRoom(id) {
        await deleteData(`${API_URL}/rooms`, id, loadRooms);
    }

    // ==========================
    // Funções para Abrir os Modais
    // ==========================

    // Função para mostrar o modal de edifício
    function showBuildingModal() {
        closeBuildingModal(); // Limpa o modal antes de abrir
        $('#buildingModal').show();
    }

    // Função para mostrar o modal de andar
    function showFloorModal() {
        closeFloorModal(); // Limpa o modal antes de abrir
        $('#floorModal').show();
    }

    // Função para mostrar o modal de sala
    function showRoomModal() {
        closeRoomModal(); // Limpa o modal antes de abrir
        $('#roomModal').show();
    }

    // Função para fechar o modal de edifício
    function closeBuildingModal() {
        $('#buildingModal').hide();
        $('#buildingForm')[0].reset(); // Limpa o formulário
    }

    // Função para fechar o modal de andar
    function closeFloorModal() {
        $('#floorModal').hide();
        $('#floorForm')[0].reset(); // Limpa o formulário
    }

    // Função para fechar o modal de sala
    function closeRoomModal() {
        $('#roomModal').hide();
        $('#roomForm')[0].reset(); // Limpa o formulário
    }

    // ==========================
    // Funções para Alternar entre Seções
    // ==========================

    // Função para mostrar a seção de edifícios
    function showBuildingsSection() {
        $('#buildingsSection').show();
        $('#floorsSection').hide();
        $('#roomsSection').hide();
        loadBuildings(); // Carrega os edifícios ao mostrar a seção
    }

    // Função para mostrar a seção de andares
    function showFloorsSection() {
        $('#buildingsSection').hide();
        $('#floorsSection').show();
        $('#roomsSection').hide();
        loadFloors(); // Carrega os andares ao mostrar a seção
    }

    // Função para mostrar a seção de salas
    function showRoomsSection() {
        $('#buildingsSection').hide();
        $('#floorsSection').hide();
        $('#roomsSection').show();
        loadRooms(); // Carrega as salas ao mostrar a seção
    }

    // ==========================
    // Inicialização e Carregamento
    // ==========================
    $(document).ready(function() {
        showBuildingsSection(); // Mostra a seção de edifícios por padrão ao iniciar
    });
}); 