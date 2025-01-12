<?php
// routes/resource_reservation_routes.php

require_once ROOT_PATH . '/controllers/resource_reservation_controller.php'; // Importando o controlador

function resourceReservationRoutes($request_method, $request_uri) {
    $controller = new ResourceReservationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readResourceReservation($request_uri[2]);
            } else {
                $response = $controller->readResourceReservations();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createResourceReservation($data->user_id, $data->resource_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateResourceReservation($request_uri[2], $data->user_id, $data->resource_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteResourceReservation($request_uri[2]);
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