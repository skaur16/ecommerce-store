<?php
require_once '../controllers/ProductController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/CommentController.php';
require_once '../controllers/CartController.php';
require_once '../controllers/OrderController.php';

// Parse the request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Example: /api/products/1
$uriParts = explode('/', trim($uri, '/'));

if ($uriParts[0] === 'api') {
    switch ($uriParts[1]) {
        case 'products':
            $controller = new ProductController();
            if ($method === 'GET' && isset($uriParts[2])) {
                $controller->getProduct($uriParts[2]);
            }
            // Add other product routes here...
            break;
        case 'users':
            $controller = new UserController();
            // Add user routes here...
            break;
        // Add other cases for comments, cart, orders...
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}