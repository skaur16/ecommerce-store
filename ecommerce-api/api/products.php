<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

$response = ['success' => false, 'products' => [], 'message' => ''];

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        $response['message'] = 'Database connection failed.';
        echo json_encode($response);
        exit;
    }
    error_log('DB connection established');
    $productModel = new Product($db);
    $products = $productModel->getAll();
    error_log('Product query executed');
    if ($products !== false) {
        $response['success'] = true;
        $response['products'] = $products;
    } else {
        $response['message'] = 'Failed to fetch products.';
    }
} catch (Throwable $e) {
    $response['success'] = false;
    $response['message'] = 'Server error: ' . $e->getMessage();
}
echo json_encode($response); 