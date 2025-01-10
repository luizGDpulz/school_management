<?php
// routes/color_routes.php

include_once '../controllers/color_controller.php'; // Importando o controlador

function colorRoutes($request_method, $request_uri) {
    $controller = new ColorController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readColor($request_uri[1]);
            } else {
                echo $controller->readColors();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createColor($data->name, $data->hex_code);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateColor($request_uri[1], $data->name, $data->hex_code);
            break;
        case 'DELETE':
            echo $controller->deleteColor($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 