<?php
require_once 'Database.php';

class Conversation { 
    private PDO $conn;

    public function __construct() { 
        $this->conn = Database::getConnection();
    }

    public function getAllByUserId(int $userId): array { 
        $query = "SELECT * FROM conversations WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdAndUser(int $id, int $userId): ?array {
        $query = "SELECT * FROM conversations WHERE id = :id AND user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getMessages(int $conversationId): array {
        $query = "SELECT role, content FROM messages 
                  WHERE conversation_id = :conv_id 
                  ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conv_id', $conversationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $title = 'New Chat'): int {
        $query = "INSERT INTO conversations (user_id, title, created_at) 
                  VALUES (:user_id, :title, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        if ($stmt->execute()) {
            return (int) $this->conn->lastInsertId();
        }
        return 0;
    }

    public function addMessage(int $conversationId, string $role, string $content): bool {
        $query = "INSERT INTO messages (conversation_id, role, content, created_at) 
                  VALUES (:conv_id, :role, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conv_id', $conversationId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    public function deleteByIdAndUser(int $id, int $userId): bool {
        $this->conn->beginTransaction();

        try {
            // Delete messages first
            $queryMsg = "DELETE FROM messages WHERE conversation_id = :conv_id";
            $stmtMsg = $this->conn->prepare($queryMsg);
            $stmtMsg->bindParam(':conv_id', $id, PDO::PARAM_INT);
            $stmtMsg->execute();

            // Delete conversation
            $query = "DELETE FROM conversations WHERE id = :id AND user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $success = $stmt->execute();

            if ($success && $stmt->rowCount() > 0) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateTitle(int $id, int $userId, string $title): bool {
        $query = "UPDATE conversations SET title = :title 
                  WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $success = $stmt->execute();
        return $success && $stmt->rowCount() > 0;
    }
}
?>