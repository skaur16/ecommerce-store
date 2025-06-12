<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cart.php';

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = intval($_POST['product_id'] ?? 0);
        if (isset($_SESSION['user_id'])) {
            $database = new Database();
            $db = $database->getConnection();
            $cartModel = new Cart($db);
            $result = $cartModel->removeItem($_SESSION['user_id'], $productId);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Product removed from cart!';
            } else {
                $response['message'] = 'Failed to remove product from cart.';
            }
        } else {
            $response['message'] = 'Not logged in.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }
} catch (Throwable $e) {
    $response['success'] = false;
    $response['message'] = 'Server error: ' . $e->getMessage();
}
echo json_encode($response); 