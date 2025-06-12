<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

$response = ['success' => false, 'products' => [], 'message' => ''];

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$products = $productModel->getAll();
if ($products !== false) {
    $response['success'] = true;
    $response['products'] = $products;
} else {
    $response['message'] = 'Failed to fetch products.';
}
echo json_encode($response); 