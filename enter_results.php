<?php
session_start();
// Alleen de admin mag deze pagina gebruiken
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
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
        $melding = "Wedstrijdresultaten succesvol ingevoerd!";
    } catch (PDOException $e) {
        $melding = "Fout: " . $e->getMessage();
    }
}

// Met teamnamen, zodat je in de lijst ziet welke wedstrijd het is
$stmtMatches = $db->query("SELECT matches.*, teams1.team_name AS team1_name, teams2.team_name AS team2_name FROM matches
                           JOIN teams AS teams1 ON matches.team1_id = teams1.team_id
                           JOIN teams AS teams2 ON matches.team2_id = teams2.team_id
                           ORDER BY matches.match_date");
$matches = $stmtMatches->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Uitslagen Invoeren</title>
</head>
<body class="bg-black text-white font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 text-white p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-center">Uitslagen Invoeren</h1>
    </header>

    <!-- Main content -->
    <main class="container mx-auto p-8 flex-grow">

        <!-- Formulier voor uitslagen invoeren -->
        <?php if (!empty($melding)): ?>
            <p class="mb-6 p-4 rounded-lg bg-gray-800 text-center font-semibold"><?php echo htmlspecialchars($melding); ?></p>
        <?php endif; ?>
        <form method="post" action="" class="bg-gray-800 p-6 rounded-lg shadow-xl">
            <div class="mb-6">
                <label for="match_id" class="block text-lg font-semibold mb-2">Selecteer Wedstrijd:</label>
                <select id="match_id" name="match_id" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
                    <?php foreach ($matches as $match): ?>
                        <option value="<?php echo $match['match_id']; ?>"><?php echo htmlspecialchars($match['match_date'] . ': ' . $match['team1_name'] . ' – ' . $match['team2_name']); ?><?php if ($match['team1_results'] !== null) echo ' (' . $match['team1_results'] . '-' . $match['team2_results'] . ')'; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="team1_results" class="block text-lg font-semibold mb-2">Team 1 Uitslagen:</label>
                <input type="number" id="team1_results" name="team1_results" min="0" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
            </div>

            <div class="mb-6">
                <label for="team2_results" class="block text-lg font-semibold mb-2">Team 2 Uitslagen:</label>
                <input type="number" id="team2_results" name="team2_results" min="0" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
            </div>

            <div class="text-center">
                <input type="submit" value="Uitslagen Invoeren" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
            </div>
        </form>

        <!-- Terug naar Dashboard link -->
        <div class="mt-8 text-center">
            <a href="admin_.php" class="text-blue-600 hover:underline text-lg">Terug naar Dashboard</a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center mt-12">
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi. Alle rechten voorbehouden.</p>
    </footer>

</body>
</html>
