<?php
require_once('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matchId = $_POST['match_id'];
    $team1Results = $_POST['team1_results'];
    $team2Results = $_POST['team2_results'];

    $stmt = $db->prepare("UPDATE matches SET team1_results = :team1_results, team2_results = :team2_results WHERE match_id = :match_id");
    $stmt->bindParam(':team1_results', $team1Results);
    $stmt->bindParam(':team2_results', $team2Results);
    $stmt->bindParam(':match_id', $matchId);

    try {
        $stmt->execute();
        echo "Wedstrijdresultaten succesvol ingevoerd!";
    } catch (PDOException $e) {
        echo "Fout: " . $e->getMessage();
    }
}

$stmtMatches = $db->query("SELECT * FROM matches");
$matches = $stmtMatches->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Uitslagen Invoeren</title>
</head>
<body>
    <h2>Uitslagen Invoeren</h2>

    <form method="post" action="">
        <label for="match_id">Selecteer Wedstrijd:</label>
        <select id="match_id" name="match_id" required>
            <?php foreach ($matches as $match): ?>
                <option value="<?php echo $match['match_id']; ?>"><?php echo $match['match_id']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>
        <label for="team1_results">Team 1 Uitslagen:</label>
        <input type="number" id="team1_results" name="team1_results" required>
        <br>
        <br>
        <label for="team2_results">Team 2 Uitslagen:</label>
        <input type="number" id="team2_results" name="team2_results" required>
        <br>
        <br>
        <input type="submit" value="Uitslagen Invoeren">
    </form>

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
