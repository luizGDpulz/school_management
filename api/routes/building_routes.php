<?php
// routes/building_routes.php

include_once '../controllers/building_controller.php'; // Importando o controlador

function buildingRoutes($request_method, $request_uri) {
    $controller = new BuildingController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readBuilding($request_uri[1]);
            } else {
                echo $controller->readBuildings();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createBuilding($data->name, $data->address, $data->floors_number, $data->color_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateBuilding($request_uri[1], $data->name, $data->address, $data->floors_number, $data->color_id);
            break;
        case 'DELETE':
            echo $controller->deleteBuilding($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 