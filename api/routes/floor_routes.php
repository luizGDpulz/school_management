<?php
// routes/floor_routes.php

include_once '../controllers/floor_controller.php'; // Importando o controlador

function floorRoutes($request_method, $request_uri) {
    $controller = new FloorController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readFloor($request_uri[1]);
            } else {
                echo $controller->readFloors();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createFloor($data->building_id, $data->name, $data->rooms_number, $data->color_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateFloor($request_uri[1], $data->building_id, $data->name, $data->rooms_number, $data->color_id);
            break;
        case 'DELETE':
            echo $controller->deleteFloor($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 