<?php
// routes/status_routes.php

include_once '../controllers/status_controller.php'; // Importando o controlador

function statusRoutes($request_method, $request_uri) {
    $controller = new StatusController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readStatus($request_uri[1]);
            } else {
                echo $controller->readStatuses();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createStatus($data->status_name);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateStatus($request_uri[1], $data->status_name);
            break;
        case 'DELETE':
            echo $controller->deleteStatus($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 