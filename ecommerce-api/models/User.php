<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($email, $password, $username, $address) {
        $query = "INSERT INTO $this->table (email, password, username, shippingAddress) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$email, password_hash($password, PASSWORD_DEFAULT), $username, $address]);
    }

    public function login($email) {
        $query = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
