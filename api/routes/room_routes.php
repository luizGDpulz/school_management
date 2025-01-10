<?php
// routes/room_routes.php

include_once '../controllers/room_controller.php'; // Importando o controlador

function roomRoutes($request_method, $request_uri) {
    $controller = new RoomController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readRoom($request_uri[1]);
            } else {
                echo $controller->readRooms();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createRoom($data->floor_id, $data->name, $data->capacity, $data->room_type_id, $data->color_id, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateRoom($request_uri[1], $data->floor_id, $data->name, $data->capacity, $data->room_type_id, $data->color_id, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteRoom($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 