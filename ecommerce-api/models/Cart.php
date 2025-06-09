<?php
class Cart {
    private $conn;
    private $table = "cart";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        // Check if product already in cart for user
        $query = "SELECT quantity FROM $this->table WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId, $productId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update quantity
            $newQty = $existing['quantity'] + $quantity;
            $updateQuery = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            return $updateStmt->execute([$newQty, $userId, $productId]);
        } else {
            // Insert new row
            $insertQuery = "INSERT INTO $this->table (userID, productID, quantity) VALUES (?, ?, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);
            return $insertStmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function getUserCart($userId) {
        $query = "SELECT * FROM $this->table WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt;
    }

    public function updateQuantity($userId, $productId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($userId, $productId);
        }
        $query = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $userId, $productId]);
    }

    public function removeItem($userId, $productId) {
        $query = "DELETE FROM $this->table WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $productId]);
    }
}
