<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Beheerdersdashboard</title> 
</head>
<body>
    <h2>Welkom, Admin!</h2>
    
    <ul>
        <li><a href="view_teams.php">Teams bekijken</a></li>
        <li><a href="plan_matches.php">Wedstrijden plannen</a></li>
        <li><a href="enter_results.php">Uitslagen invoeren</a></li>
    </ul>
    
    <p><a href="logout.php">Uitloggen</a></p> 
    
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
