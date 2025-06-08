<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $db;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($this->db);
    }

    // Get all products (for product listing page)
    public function getAllProducts() {
        $result = $this->productModel->getAll();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one product (for index/featured page)
    public function getSingleProduct() {
        $stmt = $this->productModel->getAll();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get a product by its ID (for details page)
    public function getProductById($id) {
        $result = $this->productModel->getById($id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // Create a product (optional: for admin functionality)
    public function createProduct($description, $image, $price, $shippingCost) {
        return $this->productModel->create($description, $image, $price, $shippingCost);
    }
}
