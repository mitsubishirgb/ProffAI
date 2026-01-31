<?php
require_once __DIR__ . '/../config/database.php';
require_once 'User.php';

class Auth { 
    private User $user;

    public function __construct() {
        session_start();
        $this->user = new User(Database::getConnection());
    }

    public function login($email, $password): bool { 
        $user = $this->user->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; 
            return true;
        }
        return false;   
    }

    public function signup($firstName, $lastName, $email, $password): bool { 
        if ($this->user->findByEmail($email)) { 
            return false; 
        } 
        return $this->user->create($firstName, $lastName, $email, $password);
    }

    public function logout() { 
        session_unset();
        session_destroy();
    }

    public function isLoggedIn(): bool { 
        return isset($_SESSION['user_id']);
    }

    public function userId(): ?int { 
        return $_SESSION['user_id'] ?? null;
    }

    public static function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../public/pages/login.php");
            exit;
        }
    }

    public static function requireRole(string $role) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            header("Location: ../public/pages/login.php");
            exit;
        }
    }

    public function getUserByEmail(string $email): ?array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, first_name, email, role FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
?>
