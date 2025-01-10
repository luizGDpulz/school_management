<?php
// routes/notification_routes.php

include_once '../controllers/notification_controller.php'; // Importando o controlador

function notificationRoutes($request_method, $request_uri) {
    $controller = new NotificationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[1])) {
                echo $controller->readNotification($request_uri[1]);
            } else {
                echo $controller->readNotifications();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->createNotification($data->user_id, $data->message, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            echo $controller->updateNotification($request_uri[1], $data->user_id, $data->message, $data->status_id);
            break;
        case 'DELETE':
            echo $controller->deleteNotification($request_uri[1]);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed."]);
            break;
    }
}
?> 