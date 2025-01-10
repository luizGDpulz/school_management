<?php
// routes/resource_routes.php

include_once '../controllers/resource_controller.php'; // Importando o controlador

function resourceRoutes($request_method, $request_uri) {
    $controller = new ResourceController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readResource($request_uri[1]);
            } else {
                echo $controller->readResources();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createResource($data->name, $data->quantity, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateResource($request_uri[1], $data->name, $data->quantity, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteResource($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 