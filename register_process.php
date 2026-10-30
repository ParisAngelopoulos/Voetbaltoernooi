<?php
require_once('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $teamName = $_POST['team_name'];
    $players = $_POST['players'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmtUser = $db->prepare("INSERT INTO vt_users (username, password_hash) VALUES (:username, :password_hash)");
    $stmtUser->bindParam(':username', $username);
    $stmtUser->bindParam(':password_hash', $hashedPassword);

    try {
        $db->beginTransaction();

        $stmtUser->execute();

        $userId = $db->lastInsertId();

        $stmtTeam = $db->prepare("INSERT INTO teams (team_name, user_id) VALUES (:team_name, :user_id)");
        $stmtTeam->bindParam(':team_name', $teamName);
        $stmtTeam->bindParam(':user_id', $userId);
        $stmtTeam->execute();

        $teamId = $db->lastInsertId();

        $stmtPlayers = $db->prepare("INSERT INTO players (player_name, team_id) VALUES (:player_name, :team_id)");
        $stmtPlayers->bindParam(':team_id', $teamId);

        foreach (array_filter(array_map('trim', $players)) as $playerName) {
            $stmtPlayers->bindParam(':player_name', $playerName);
            $stmtPlayers->execute();
        }

        $db->commit();

        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        $db->rollBack();
        // 23000 = de gebruikersnaam bestaat al (UNIQUE in de database)
        echo $e->getCode() == 23000 ? "Deze gebruikersnaam is al in gebruik. <a href='register.php'>Probeer een andere</a>." : "Fout: " . htmlspecialchars($e->getMessage());
    }
}
?>
