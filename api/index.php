<?php
// index.php

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Include the routes
require_once 'routes/user_routes.php';
require_once 'routes/color_routes.php';
require_once 'routes/room_type_routes.php';
require_once 'routes/status_routes.php';
require_once 'routes/building_routes.php';
require_once 'routes/floor_routes.php';
require_once 'routes/room_routes.php';
require_once 'routes/resource_routes.php';
require_once 'routes/class_routes.php';
require_once 'routes/room_reservation_routes.php';
require_once 'routes/resource_reservation_routes.php';
require_once 'routes/notification_routes.php';

// Get the request method and URI
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Route the request
switch ($request_uri[0]) {
    case 'users':
        userRoutes($request_method, $request_uri);
        break;
    case 'colors':
        colorRoutes($request_method, $request_uri);
        break;
    case 'room_types':
        roomTypeRoutes($request_method, $request_uri);
        break;
    case 'statuses':
        statusRoutes($request_method, $request_uri);
        break;
    case 'buildings':
        buildingRoutes($request_method, $request_uri);
        break;
    case 'floors':
        floorRoutes($request_method, $request_uri);
        break;
    case 'rooms':
        roomRoutes($request_method, $request_uri);
        break;
    case 'resources':
        resourceRoutes($request_method, $request_uri);
        break;
    case 'classes':
        classRoutes($request_method, $request_uri);
        break;
    case 'room_reservations':
        roomReservationRoutes($request_method, $request_uri);
        break;
    case 'resource_reservations':
        resourceReservationRoutes($request_method, $request_uri);
        break;
    case 'notifications':
        notificationRoutes($request_method, $request_uri);
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found."]);
        break;
}
?>
