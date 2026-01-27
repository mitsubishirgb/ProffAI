<?php
require_once __DIR__ . '/../config/database.php';
require_once 'User.php';

class Auth { 
    private User $user;

    public function __construct() {
        session_start();
        $this->user = new User(DataBase::getConnection());
    }

    public function login($email, $password): bool { 
        $user = $this->user->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
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
}
