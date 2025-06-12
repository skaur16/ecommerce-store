<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cart.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id'] ?? 0);
    $quantity = max(1, intval($_POST['quantity'] ?? 1));
    if (isset($_SESSION['user_id'])) {
        $database = new Database();
        $db = $database->getConnection();
        $cartModel = new Cart($db);
        $result = $cartModel->addToCart($_SESSION['user_id'], $productId, $quantity);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Product added to cart!';
        } else {
            $response['message'] = 'Failed to add product to cart.';
        }
    } else {
        $response['message'] = 'Not logged in.';
    }
} else {
    $response['message'] = 'Invalid request.';
}
echo json_encode($response); 