<?php
// routes/resource_routes.php

require_once ROOT_PATH . '/controllers/resource_controller.php'; // Importando o controlador

function resourceRoutes($request_method, $request_uri) {
    $controller = new ResourceController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readResource($request_uri[2]);
            } else {
                $response = $controller->readResources();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createResource($data->name, $data->quantity, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateResource($request_uri[2], $data->name, $data->quantity, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteResource($request_uri[2]);
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