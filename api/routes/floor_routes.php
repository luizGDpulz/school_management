<?php
// routes/floor_routes.php

require_once ROOT_PATH . '/controllers/floor_controller.php'; // Importando o controlador

function floorRoutes($request_method, $request_uri) {
    $controller = new FloorController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readFloor($request_uri[2]);
            } else {
                $response = $controller->readFloors();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createFloor($data->building_id, $data->name, $data->rooms_number, $data->color_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateFloor($request_uri[2], $data->building_id, $data->name, $data->rooms_number, $data->color_id);
            break;
        case 'DELETE':
            $response = $controller->deleteFloor($request_uri[2]);
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