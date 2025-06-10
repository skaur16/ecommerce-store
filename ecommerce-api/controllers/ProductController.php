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
        return $this->productModel->getAll();
    }

    // Get one product (for index/featured page)
    public function getSingleProduct() {
        $products = $this->productModel->getAll();
        return !empty($products) ? $products[0] : null;
    }

    // Get a product by its ID (for details page)
    public function getProductById($id) {
        return $this->productModel->getById($id);
    }

    // Create a product (optional: for admin functionality)
    public function createProduct($description, $image, $price, $shippingCost) {
        return $this->productModel->create($description, $image, $price, $shippingCost);
    }
}
