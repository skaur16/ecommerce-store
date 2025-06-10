<?php
require_once __DIR__ . '/../controllers/CartController.php';

header('Content-Type: application/json');

$cartController = new CartController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['userId']) || !isset($data['productId']) || !isset($data['quantity'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }

    $result = $cartController->addToCart($data['userId'], $data['productId'], $data['quantity']);
    echo json_encode($result);
    exit;
} 