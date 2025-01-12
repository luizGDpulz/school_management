<?php
// routes/user_routes.php

require_once ROOT_PATH . '/controllers/user_controller.php'; // Importando o controlador

function userRoutes($request_method, $request_uri) {
    $controller = new UserController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readUser($request_uri[2]);
            } else {
                $response = $controller->readUsers();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createUser($data->name, $data->email, $data->role);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateUser($request_uri[2], $data->name, $data->email, $data->role);
            break;
        case 'DELETE':
            $response = $controller->deleteUser($request_uri[2]);
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