<?php
// routes/color_routes.php

require_once ROOT_PATH . '/controllers/color_controller.php'; // Importando o controlador

function colorRoutes($request_method, $request_uri) {
    $controller = new ColorController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readColor($request_uri[2]);
            } else {
                $response = $controller->readColors();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createColor($data->name, $data->hex_code);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateColor($request_uri[2], $data->name, $data->hex_code);
            break;
        case 'DELETE':
            $response = $controller->deleteColor($request_uri[2]);
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