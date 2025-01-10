<?php
// routes/user_routes.php

include_once '../controllers/user_controller.php'; // Importando o controlador

function userRoutes($request_method, $request_uri) {
    $controller = new UserController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readUser($request_uri[1]);
            } else {
                echo $controller->readUsers();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createUser($data->name, $data->email, $data->role);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateUser($request_uri[1], $data->name, $data->email, $data->role);
            break;
        case 'DELETE':
            echo $controller->deleteUser($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 