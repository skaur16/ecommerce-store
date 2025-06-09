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

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE productID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Return single product as array
    }

    public function create($description, $image, $price, $shippingCost) {
        $query = "INSERT INTO $this->table (description, image, price, shippingCost) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$description, $image, $price, $shippingCost]);
    }

    public function update($id, $description, $image, $price, $shippingCost) {
        $query = "UPDATE $this->table SET description = ?, image = ?, price = ?, shippingCost = ? WHERE productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$description, $image, $price, $shippingCost, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
