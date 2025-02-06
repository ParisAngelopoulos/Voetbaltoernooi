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
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Speler Dashboard</title>
</head>
<body class="bg-black text-white font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 text-white p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-center">Speler Dashboard</h1>
    </header>

    <!-- Main content -->
    <main class="container mx-auto p-8 flex-grow">

        <!-- Teams bekijken -->
        <section class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Teams bekijken</h3>
            <?php if (!empty($teams)): ?>
                <table class="table-auto w-full border-collapse border border-gray-700">
                    <thead>
                        <tr>
                            <th class="border p-2">Teamnaam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team): ?>
                            <tr>
                                <td class="border p-2"><?= $team['team_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Geen teams gevonden.</p>
            <?php endif; ?>
        </section>

        <!-- Wedstrijdplanning en uitslagen -->
        <section>
            <h3 class="text-2xl font-semibold mb-4">Wedstrijdplanning en uitslagen zien</h3>
            <?php if (!empty($matches)): ?>
                <table class="table-auto w-full border-collapse border border-gray-700">
                    <thead>
                        <tr>
                            <th class="border p-2">Wedstrijd ID</th>
                            <th class="border p-2">Team 1</th>
                            <th class="border p-2">Team 2</th>
                            <th class="border p-2">Wedstrijddatum</th>
                            <th class="border p-2">Team 1 Resultaten</th>
                            <th class="border p-2">Team 2 Resultaten</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matches as $match): ?>
                            <tr>
                                <td class="border p-2"><?= $match['match_id']; ?></td>
                                <td class="border p-2"><?= $match['team1_name']; ?></td>
                                <td class="border p-2"><?= $match['team2_name']; ?></td>
                                <td class="border p-2"><?= $match['match_date']; ?></td>
                                <td class="border p-2"><?= $match['team1_results']; ?></td>
                                <td class="border p-2"><?= $match['team2_results']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Geen wedstrijden gevonden.</p>
            <?php endif; ?>
        </section>

    </main>

    <!-- Uitloggen knop -->
    <div class="text-center mt-8">
        <a href="logout.php" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition">Uitloggen</a>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center mt-12">
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi. Alle rechten voorbehouden.</p>
    </footer>

</body>
</html>
