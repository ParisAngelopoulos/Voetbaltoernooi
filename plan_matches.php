<?php
require_once('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team1Id = $_POST['team1'];
    $team2Id = $_POST['team2'];
    $matchDate = $_POST['match_date'];

    $stmt = $db->prepare("INSERT INTO matches (team1_id, team2_id, match_date) VALUES (:team1_id, :team2_id, :match_date)");
    $stmt->bindParam(':team1_id', $team1Id);
    $stmt->bindParam(':team2_id', $team2Id);
    $stmt->bindParam(':match_date', $matchDate);

    try {
        $stmt->execute();
        echo "Wedstrijd succesvol gepland!";
    } catch (PDOException $e) {
        echo "Fout: " . $e->getMessage();
    }
}

$stmtTeams = $db->query("SELECT * FROM teams");
$teams = $stmtTeams->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wedstrijden Plannen</title>
</head>
<body>
    <h2>Wedstrijden Plannen</h2>

    <form method="post" action="">
        <label for="team1">Team 1:</label>
        <select id="team1" name="team1" required>
            <?php foreach ($teams as $team): ?>
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>

        <label for="team2">Team 2:</label>
        <select id="team2" name="team2" required>
            <?php foreach ($teams as $team): ?>
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>

        <label for="match_date">Wedstrijddatum:</label>
        <input type="datetime-local" id="match_date" name="match_date" required>
        <br>
        <br>

        <input type="submit" value="Wedstrijd Plannen">
    </form>

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
