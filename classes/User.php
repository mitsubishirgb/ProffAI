<?php

class User {
    private PDO $db;
    private $table_name = 'users';

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?array {
        $query = ("SELECT * FROM {$this->table_name} WHERE email = :email");
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }

    public function create(string $firstName, string $lastName, string $email, string $password) {
        $query = "INSERT INTO {$this->table_name} 
                (first_name, last_name, email, password, role)
                VALUES (:first_name, :last_name, :email, :password, 'user')"; 
        $stmt = $this->db->prepare($query);
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash); 

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function findAll(): array {
    $stmt = $this->db->query("SELECT id, first_name, last_name, email, role FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function updateRole(int $id, string $role): bool {
        $stmt = $this->db->prepare("UPDATE {$this->table_name} SET role = :role WHERE id = :id");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
?>