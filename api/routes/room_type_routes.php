<?php
// routes/room_type_routes.php

include_once '../controllers/room_type_controller.php'; // Importando o controlador

function roomTypeRoutes($request_method, $request_uri) {
    $controller = new RoomTypeController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readRoomType($request_uri[1]);
            } else {
                echo $controller->readRoomTypes();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createRoomType($data->type_name);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateRoomType($request_uri[1], $data->type_name);
            break;
        case 'DELETE':
            echo $controller->deleteRoomType($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 