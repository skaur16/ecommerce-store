<?php
class Cart {
    private $conn;
    private $table = "cart";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        $query = "INSERT INTO $this->table (userID, productID, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $productId, $quantity]);
    }

    public function getUserCart($userId) {
        $query = "SELECT * FROM $this->table WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt;
    }

    public function removeItem($userId, $productId) {
        $query = "DELETE FROM $this->table WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $productId]);
    }
}
