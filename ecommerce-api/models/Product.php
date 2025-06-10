<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE productID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    // In your Product model (App/Models/Product.php)
    public function getById($productId)
    {
        $query = "SELECT * FROM products WHERE productID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
