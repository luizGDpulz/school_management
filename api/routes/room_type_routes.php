<?php
// routes/room_type_routes.php

require_once ROOT_PATH . '/controllers/room_type_controller.php'; // Importando o controlador

function roomTypeRoutes($request_method, $request_uri) {
    $controller = new RoomTypeController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readRoomType($request_uri[2]);
            } else {
                $response = $controller->readRoomTypes();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createRoomType($data->type_name);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateRoomType($request_uri[2], $data->type_name);
            break;
        case 'DELETE':
            $response = $controller->deleteRoomType($request_uri[2]);
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