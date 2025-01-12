<?php
// routes/status_routes.php

require_once ROOT_PATH . '/controllers/status_controller.php'; // Importando o controlador

function statusRoutes($request_method, $request_uri) {
    $controller = new StatusController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readStatus($request_uri[2]);
            } else {
                $response = $controller->readStatuses();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createStatus($data->status_name);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateStatus($request_uri[2], $data->status_name);
            break;
        case 'DELETE':
            $response = $controller->deleteStatus($request_uri[2]);
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