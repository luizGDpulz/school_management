<?php
// routes/class_routes.php

include_once '../controllers/class_controller.php'; // Importando o controlador

function classRoutes($request_method, $request_uri) {
    $controller = new ClassController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readClass($request_uri[1]);
            } else {
                echo $controller->readClasses();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createClass($data->name, $data->teacher_id, $data->schedule, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateClass($request_uri[1], $data->name, $data->teacher_id, $data->schedule, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteClass($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 