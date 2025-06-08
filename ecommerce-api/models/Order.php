<?php
class Order {
    private $conn;
    private $table = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function placeOrder($userId, $totalAmount) {
        $query = "INSERT INTO $this->table (userID, totalAmount) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $totalAmount]);
    }

    public function getUserOrders($userId) {
        $query = "SELECT * FROM $this->table WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt;
    }
}
