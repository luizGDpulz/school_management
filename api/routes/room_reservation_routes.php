<?php
// routes/room_reservation_routes.php

include_once '../controllers/room_reservation_controller.php'; // Importando o controlador

function roomReservationRoutes($request_method, $request_uri) {
    $controller = new RoomReservationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readRoomReservation($request_uri[1]);
            } else {
                echo $controller->readRoomReservations();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createRoomReservation($data->user_id, $data->room_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateRoomReservation($request_uri[1], $data->user_id, $data->room_id, $data->start_time, $data->end_time, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteRoomReservation($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 