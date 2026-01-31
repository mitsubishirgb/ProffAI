<?php
require_once 'Database.php';

class Message { 
    private PDO $conn;

    public function __construct() { 
        $this->conn = Database::getConnection();
    }

    public function create(int $conversationId, string $role, string $content): bool {
        $query = "INSERT INTO messages (conversation_id, role, content, created_at) 
                  VALUES (:conv_id, :role, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conv_id', $conversationId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    public function get(int $conversationId) : array { 
        $query = "SELECT * FROM messages WHERE conversation_id = :conversation_id ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conversation_id', $conversationId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}