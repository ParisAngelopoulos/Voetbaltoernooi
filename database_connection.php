<?php
// On the web host, db_config.php (written on deploy, not in git) holds the login; locally XAMPP defaults
$c = is_file(__DIR__ . '/db_config.php') ? require __DIR__ . '/db_config.php' : [];
$host = $c['host'] ?? "localhost";
$dbname = $c['database'] ?? "voetbaltoernooi";
$username = $c['user'] ?? "root";
$password = $c['password'] ?? "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
