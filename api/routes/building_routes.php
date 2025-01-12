<?php
// routes/building_routes.php

require_once ROOT_PATH . '/controllers/building_controller.php'; // Importando o controlador

function buildingRoutes($request_method, $request_uri) {
    $controller = new BuildingController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readBuilding($request_uri[2]);
            } else {
                $response = $controller->readBuildings();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createBuilding($data->name, $data->address, $data->floors_number, $data->color_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateBuilding($request_uri[2], $data->name, $data->address, $data->floors_number, $data->color_id);
            break;
        case 'DELETE':
            $response = $controller->deleteBuilding($request_uri[2]);
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