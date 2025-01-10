<?php
// routes/resource_reservation_routes.php

include_once '../controllers/resource_reservation_controller.php'; // Importando o controlador

function resourceReservationRoutes($request_method, $request_uri) {
    $controller = new ResourceReservationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readResourceReservation($request_uri[1]);
            } else {
                echo $controller->readResourceReservations();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createResourceReservation($data->user_id, $data->resource_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateResourceReservation($request_uri[1], $data->user_id, $data->resource_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteResourceReservation($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 