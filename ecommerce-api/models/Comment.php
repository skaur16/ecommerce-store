<?php
class Comment {
    private $conn;
    private $table = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment($productId, $userId, $rating, $text, $image = null) {
        try {
            $query = "INSERT INTO $this->table (productID, userID, rating, text, image, created_at) 
                     VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$productId, $userId, $rating, $text, $image]);
        } catch (PDOException $e) {
            // If created_at column doesn't exist, try without it
            $query = "INSERT INTO $this->table (productID, userID, rating, text, image) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$productId, $userId, $rating, $text, $image]);
        }
    }

    public function getCommentsByProductId($productId) {
        try {
            $query = "SELECT c.*, u.username 
                     FROM $this->table c 
                     JOIN users u ON c.userID = u.userID 
                     WHERE c.productID = ? 
                     ORDER BY c.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If created_at column doesn't exist, order by commentID
            $query = "SELECT c.*, u.username 
                     FROM $this->table c 
                     JOIN users u ON c.userID = u.userID 
                     WHERE c.productID = ? 
                     ORDER BY c.commentID DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function deleteComment($commentId) {
        $query = "DELETE FROM comments WHERE commentID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $commentId);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCommentById($commentId) {
        $query = "SELECT * FROM comments WHERE commentID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $commentId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateComment($commentId, $rating, $text, $image = null) {
        $query = "UPDATE comments 
                 SET rating = :rating, 
                     text = :text, 
                     image = :image 
                 WHERE commentID = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":id", $commentId);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
