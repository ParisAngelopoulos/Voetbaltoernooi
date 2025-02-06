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
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Wedstrijden Plannen</title>
</head>
<body class="bg-black text-white font-sans min-h-screen">

    <!-- Header -->
    <header class="bg-gray-900 text-white p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-center">Wedstrijden Plannen</h1>
    </header>

    <!-- Main content -->
    <main class="container mx-auto p-8">

        <!-- Formulier voor wedstrijdplanning -->
        <form method="post" action="" class="bg-gray-800 p-6 rounded-lg shadow-xl">
            <div class="mb-6">
                <label for="team1" class="block text-lg font-semibold mb-2">Team 1:</label>
                <select id="team1" name="team1" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="team2" class="block text-lg font-semibold mb-2">Team 2:</label>
                <select id="team2" name="team2" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="match_date" class="block text-lg font-semibold mb-2">Wedstrijddatum:</label>
                <input type="datetime-local" id="match_date" name="match_date" class="w-full p-3 bg-gray-700 text-white rounded-md" required>
            </div>

            <div class="text-center">
                <input type="submit" value="Wedstrijd Plannen" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
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
