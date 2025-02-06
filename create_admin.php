<?php
// Vereist databaseverbinding
require_once('database_connection.php');

// Het wachtwoord dat je wilt gebruiken
$password = 'admin';

// Wachtwoord hashen
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// SQL-query om de nieuwe admin toe te voegen
$query = "INSERT INTO `users` (`username`, `password_hash`, `role`, `loggedin`) 
          VALUES ('admin', :password_hash, 'admin', 0)";

$stmt = $db->prepare($query);
$stmt->bindParam(':password_hash', $hashedPassword);

// Voer de query uit
if ($stmt->execute()) {
    echo "Nieuwe admin toegevoegd!";
} else {
    echo "Er is een fout opgetreden bij het toevoegen van de admin.";
}
?>
