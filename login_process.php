<?php
require_once('database_connection.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password_hash'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash']) && $user['role'] == 'admin') {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = 'admin';

        header("Location: admin_.php");
        exit();
    } elseif ($user && password_verify($password, $user['password_hash']) && $user['role'] == 'user') {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = 'user';

        header("Location: user_dashboard.php");
        exit();
    } else {
        header("Location: login.php");
        echo "Ongeldige gebruikersnaam, wachtwoord of rol.";
    }
}
?>
