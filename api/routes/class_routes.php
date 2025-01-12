<?php
// routes/class_routes.php

include_once ROOT_PATH . '/controllers/class_controller.php'; // Importando o controlador

function classRoutes($request_method, $request_uri) {
    $controller = new ClassController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readClass($request_uri[2]);
            } else {
                $response = $controller->readClasses();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createClass($data->name, $data->teacher_id, $data->schedule, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateClass($request_uri[2], $data->name, $data->teacher_id, $data->schedule, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteClass($request_uri[2]);
            break;
        default:
            http_response_code(405);
            $response = ["message" => "Method not allowed."];
            break;
    }

    // Retornar resposta em formato JSON
    echo json_encode($response ?? ["error" => "No response"], JSON_UNESCAPED_UNICODE);
}
?>