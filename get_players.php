<?php

session_start();
require_once('database_connection.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamName = $_POST['team_name'];

    try {
        $stmt = $db->prepare("SELECT players.player_id, players.player_name FROM players
                             JOIN teams ON players.team_id = teams.team_id
                             WHERE teams.team_name = :team_name");
        $stmt->bindParam(':team_name', $teamName);
        $stmt->execute();

        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($players, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
