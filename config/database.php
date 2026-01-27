<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'proffai';
    private static $username = 'root';
    private static $password = '';
    private static ?PDO $conn = null;


    public static function getConnection() {
        if (self::$conn == null) { 
            try { 
                self::$conn = new PDO("mysql:host=" . self::$host .
                                    ";dbname=" . self::$dbname, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage()); 
            }
        }
        return self::$conn;
    
    }
}
?>
