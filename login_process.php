<?php
require_once('database_connection.php'); // Zorg ervoor dat je databaseverbinding goed is

session_start();

// Controleer of de formuliergegevens zijn verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de ingevoerde gegevens op
    $username = $_POST['username'];
    $password = $_POST['password'];  // Pas dit aan naar 'password' en niet 'password_hash'

    // Zoek de gebruiker in de database
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Als de gebruiker bestaat en het wachtwoord klopt, log dan in
    if ($user && password_verify($password, $user['password_hash'])) {
        // Stel de sessie in
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $user['role'];  // Rol van de gebruiker (admin of user)

        // Controleer de rol en stuur door naar de juiste pagina
        if ($user['role'] == 'admin') {
            header("Location: admin_.php"); // Admin-dashboard
        } else {
            header("Location: user_dashboard.php"); // Gebruiker-dashboard
        }
        exit();
    } else {
        // Als de inloggegevens onjuist zijn, stuur dan terug naar de loginpagina
        $_SESSION['error'] = "Ongeldige gebruikersnaam of wachtwoord.";
        header("Location: login.php");
        exit();
    }
}
?>
