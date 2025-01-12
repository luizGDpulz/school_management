<?php
// routes/notification_routes.php

require_once ROOT_PATH . '/controllers/notification_controller.php'; // Importando o controlador

function notificationRoutes($request_method, $request_uri) {
    $controller = new NotificationController();

    switch ($request_method) {
        case 'GET':
            if (isset($request_uri[2])) {
                $response = $controller->readNotification($request_uri[2]);
            } else {
                $response = $controller->readNotifications();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->createNotification($data->user_id, $data->message, $data->status_id);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $response = $controller->updateNotification($request_uri[2], $data->user_id, $data->message, $data->status_id);
            break;
        case 'DELETE':
            $response = $controller->deleteNotification($request_uri[2]);
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