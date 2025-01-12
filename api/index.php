<?php
define('ROOT_PATH', dirname(__FILE__)); // Define o caminho raiz do projeto

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include routes using ROOT_PATH
require_once ROOT_PATH . '/routes/user_routes.php';
require_once ROOT_PATH . '/routes/color_routes.php';
require_once ROOT_PATH . '/routes/class_routes.php';
require_once ROOT_PATH . '/routes/building_routes.php';
require_once ROOT_PATH . '/routes/floor_routes.php';
require_once ROOT_PATH . '/routes/room_routes.php';
require_once ROOT_PATH . '/routes/resource_routes.php';
require_once ROOT_PATH . '/routes/room_type_routes.php';
require_once ROOT_PATH . '/routes/notification_routes.php';
require_once ROOT_PATH . '/routes/resource_reservation_routes.php';
require_once ROOT_PATH . '/routes/room_reservation_routes.php';
require_once ROOT_PATH . '/routes/status_routes.php';

// Get the request method and URI
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Route the request
$resource = $request_uri[1] ?? null;
$id = $request_uri[2] ?? null;

switch ($resource) {
    case 'users':
        userRoutes($request_method, $request_uri);
        break;
    case 'colors':
        colorRoutes($request_method, $request_uri);
        break;
    case 'classes':
        classRoutes($request_method, $request_uri);
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
    case 'room_types':
        roomTypeRoutes($request_method, $request_uri);
        break;
    case 'notifications':
        notificationRoutes($request_method, $request_uri);
        break;
    case 'resource_reservations':
        resourceReservationRoutes($request_method, $request_uri);
        break;
    case 'room_reservations':
        roomReservationRoutes($request_method, $request_uri);
        break;
    case 'statuses':
        statusRoutes($request_method, $request_uri);
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"], JSON_UNESCAPED_UNICODE);
        break;
}
?>
