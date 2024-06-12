<?php
session_start();
require_once('database_connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

$teams = $db->query("SELECT * FROM teams")->fetchAll(PDO::FETCH_ASSOC);
$matches = $db->query("SELECT matches.match_id, teams1.team_name as team1_name, teams2.team_name as team2_name, matches.match_date, matches.team1_results, matches.team2_results FROM matches
                     JOIN teams as teams1 ON matches.team1_id = teams1.team_id
                     JOIN teams as teams2 ON matches.team2_id = teams2.team_id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Speler Dashboard</title>
</head>
<body>
    <header>
        <h1>Speler Dashboard</h1>
    </header>

    <main>
        <h2>Jouw Dashboard</h2>

        <h3>Teams bekijken</h3>
        <?php if (!empty($teams)): ?>
            <table border="1">
                <tr>
                    <th>Teamnaam</th>
                </tr>
                <?php foreach ($teams as $team): ?>
                    <tr>
                        <td><?= $team['team_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Geen teams gevonden.</p>
        <?php endif; ?>

        <h3>Wedstrijdplanning en uitslagen zien</h3>
        <?php if (!empty($matches)): ?>
            <table border="1">
                <tr>
                    <th>Wedstrijd ID</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Wedstrijddatum</th>
                    <th>Team 1 Resultaten</th>
                    <th>Team 2 Resultaten</th>
                </tr>
                <?php foreach ($matches as $match): ?>
                    <tr>
                        <td><?= $match['match_id']; ?></td>
                        <td><?= $match['team1_name']; ?></td>
                        <td><?= $match['team2_name']; ?></td>
                        <td><?= $match['match_date']; ?></td>
                        <td><?= $match['team1_results']; ?></td>
                        <td><?= $match['team2_results']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Geen wedstrijden gevonden.</p>
        <?php endif; ?>
    </main>

    <a href="logout.php">Uitloggen</a>

    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
