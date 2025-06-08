<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all products
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt;
    }

    // Get a single (first) product for homepage
    public function getOne() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT 1");
        $stmt->execute();
        return $stmt;
    }

    // Get product by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE productID = ?");
        $stmt->execute([$id]);
        return $stmt;
    }

    // Create a new product
    public function create($description, $image, $price, $shippingCost) {
        $query = "INSERT INTO $this->table (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$description, $image, $price, $shippingCost]);
    }

    // Update a product (optional for admin feature)
    public function update($id, $description, $image, $price, $shippingCost) {
        $query = "UPDATE $this->table 
                  SET description = ?, image = ?, price = ?, shippingCost = ?
                  WHERE productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$description, $image, $price, $shippingCost, $id]);
    }

    // Delete a product (optional for admin feature)
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
