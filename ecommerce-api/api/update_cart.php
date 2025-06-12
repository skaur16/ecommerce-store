<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cart.php';

$response = ['success' => false, 'cart' => [], 'message' => ''];

if (isset($_SESSION['user_id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $cartModel = new Cart($db);
    $cartItems = $cartModel->getUserCart($_SESSION['user_id']);
    if ($cartItems !== false) {
        $response['success'] = true;
        $response['cart'] = [];
        foreach ($cartItems as $item) {
            $response['cart'][] = [
                'productID' => $item['productID'],
                'description' => $item['description'],
                'image' => $item['image'],
                'price' => $item['price'],
                'shippingCost' => $item['shippingCost'],
                'quantity' => $item['quantity']
            ];
        }
    } else {
        $response['message'] = 'Failed to fetch cart.';
    }
} else {
    $response['message'] = 'Not logged in.';
}
echo json_encode($response); 