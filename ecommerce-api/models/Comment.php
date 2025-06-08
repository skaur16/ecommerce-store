<?php
class Comment {
    private $conn;
    private $table = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment($productId, $userId, $rating, $image, $text) {
        $query = "INSERT INTO $this->table (productID, userID, rating, image, text) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$productId, $userId, $rating, $image, $text]);
    }

    public function getProductComments($productId) {
        $query = "SELECT * FROM $this->table WHERE productID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$productId]);
        return $stmt;
    }
}
