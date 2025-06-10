<?php
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

echo "<h2>Products Table:</h2>";
$query = "SELECT * FROM products";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($products);
echo "</pre>";

echo "<h2>Cart Table:</h2>";
$query = "SELECT * FROM cart";
$stmt = $db->prepare($query);
$stmt->execute();
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($cart);
echo "</pre>";

echo "<h2>Cart with Products (JOIN):</h2>";
$query = "SELECT c.*, p.* FROM cart c 
          JOIN products p ON c.productID = p.productID";
$stmt = $db->prepare($query);
$stmt->execute();
$cartWithProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($cartWithProducts);
echo "</pre>"; 