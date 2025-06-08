<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt;
    }

    public function create($description, $image, $price, $shippingCost) {
        $query = "INSERT INTO $this->table (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$description, $image, $price, $shippingCost]);
    }
}
