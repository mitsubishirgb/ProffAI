<?php

class Database {
    private static ?PDO $conn = null;


    public static function getConnection() {
        if (self::$conn == null) { 
            try {   
                $db = require_once __DIR__ . '/../config/database.php';
                self::$conn = new PDO("mysql:host=" . $db['host'] .
                                    ";dbname=" . $db['dbname'], $db['username'], $db['password']);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage()); 
            }
        }
        return self::$conn;
    
    }
}
?>