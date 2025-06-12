<?php
class Cart {
    private $conn;
    private $table = "cart";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        try {
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
                $result = $updateStmt->execute([$newQty, $userId, $productId]);
                if (!$result) {
                    error_log("Error updating cart: " . print_r($updateStmt->errorInfo(), true));
                    return false;
                }
                return true;
            } else {
                // Insert new row
                $insertQuery = "INSERT INTO $this->table (userID, productID, quantity) VALUES (?, ?, ?)";
                $insertStmt = $this->conn->prepare($insertQuery);
                $result = $insertStmt->execute([$userId, $productId, $quantity]);
                if (!$result) {
                    error_log("Error inserting into cart: " . print_r($insertStmt->errorInfo(), true));
                    return false;
                }
                return true;
            }
        } catch (PDOException $e) {
            error_log("Database error in addToCart: " . $e->getMessage());
            return false;
        }
    }

    public function getUserCart($userId) {
        try {
            $query = "SELECT 
                c.quantity,
                p.productID,
                p.description,
                p.image,
                p.price,
                p.shippingCost
            FROM $this->table c 
            INNER JOIN products p ON c.productID = p.productID 
            WHERE c.userID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getUserCart: " . $e->getMessage());
            return false;
        }
    }

    public function updateQuantity($userId, $productId, $quantity) {
        try {
            if ($quantity <= 0) {
                error_log("Removing item: userId=$userId, productId=$productId");
                return $this->removeItem($userId, $productId);
            }
            $query = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$quantity, $userId, $productId]);
            error_log("Updating cart: userId=$userId, productId=$productId, quantity=$quantity, result=" . ($result ? 'OK' : 'FAIL'));
            if (!$result) {
                error_log("Error updating quantity: " . print_r($stmt->errorInfo(), true));
                return false;
            }
            return true;
        } catch (PDOException $e) {
            error_log("Database error in updateQuantity: " . $e->getMessage());
            return false;
        }
    }

    public function removeItem($userId, $productId) {
        try {
            $query = "DELETE FROM $this->table WHERE userID = ? AND productID = ?";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$userId, $productId]);
            if (!$result) {
                error_log("Error removing item: " . print_r($stmt->errorInfo(), true));
                return false;
            }
            return true;
        } catch (PDOException $e) {
            error_log("Database error in removeItem: " . $e->getMessage());
            return false;
        }
    }
}
