<?php
// routes/room_reservation_routes.php

require_once ROOT_PATH . '/controllers/room_reservation_controller.php'; // Importando o controlador

function roomReservationRoutes($request_method, $request_uri) {
    $controller = new RoomReservationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readRoomReservation($request_uri[2]);
            } else {
                $response = $controller->readRoomReservations();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createRoomReservation($data->user_id, $data->room_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateRoomReservation($request_uri[2], $data->user_id, $data->room_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteRoomReservation($request_uri[2]);
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