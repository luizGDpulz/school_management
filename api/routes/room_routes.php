<?php
// routes/room_routes.php

require_once ROOT_PATH . '/controllers/room_controller.php'; // Importando o controlador

function roomRoutes($request_method, $request_uri) {
    $controller = new RoomController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readRoom($request_uri[2]);
            } else {
                $response = $controller->readRooms();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createRoom($data->floor_id, $data->name, $data->capacity, $data->room_type_id, $data->color_id, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateRoom($request_uri[2], $data->floor_id, $data->name, $data->capacity, $data->room_type_id, $data->color_id, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteRoom($request_uri[2]);
            break;
        default:
            http_response_code(405);
            $response = ["message" => "Method not allowed."];
            break;
    }

    // Return response in JSON format
    echo json_encode($response ?? ["error" => "No response"], JSON_UNESCAPED_UNICODE);
}
?> 