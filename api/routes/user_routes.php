<?php
// routes/user_routes.php

require_once ROOT_PATH . '/controllers/user_controller.php'; // Importing the controller

function userRoutes($request_method, $request_uri) {
    $controller = new UserController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2]) && $request_uri[2] === 'roles') {
                $response = $controller->getRoles();
            } elseif (isset($request_uri[2])) {
                $response = $controller->readUser($request_uri[2]);
            } else {
                $response = $controller->readUsers();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createUser($data->name, $data->email, $data->role, $data->password);
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