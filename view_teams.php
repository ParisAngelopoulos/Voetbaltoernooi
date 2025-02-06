<?php
session_start();
require_once('database_connection.php');

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

        <!-- Welkomstbericht -->
        <h2 class="text-3xl font-semibold text-center mb-6">Jouw Dashboard</h2>

        <!-- Teams bekijken -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold text-center text-blue-500 mb-4">Teams bekijken</h3>
            <?php if (!empty($teams)): ?>
                <table class="w-full table-auto border-collapse border border-gray-700 text-center">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="p-4">Teamnaam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team): ?>
                            <tr class="hover:bg-gray-700 cursor-pointer">
                                <td class="team-name p-4"><?= $team['team_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Geen teams gevonden.</p>
            <?php endif; ?>
        </div>

        <!-- Wedstrijdplanning en uitslagen zien -->
        <div>
            <h3 class="text-2xl font-semibold text-center text-blue-500 mb-4">Wedstrijdplanning en uitslagen zien</h3>
            <?php if (!empty($matches)): ?>
                <table class="w-full table-auto border-collapse border border-gray-700 text-center">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="p-4">Team 1</th>
                            <th class="p-4">Team 2</th>
                            <th class="p-4">Wedstrijddatum</th>
                            <th class="p-4">Team 1 Resultaten</th>
                            <th class="p-4">Team 2 Resultaten</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matches as $match): ?>
                            <tr class="hover:bg-gray-700">
                                <td class="p-4"><?= $match['team1_name']; ?></td>
                                <td class="p-4"><?= $match['team2_name']; ?></td>
                                <td class="p-4"><?= $match['match_date']; ?></td>
                                <td class="p-4"><?= $match['team1_results']; ?></td>
                                <td class="p-4"><?= $match['team2_results']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Geen wedstrijden gevonden.</p>
            <?php endif; ?>
        </div>

        <!-- Terug naar dashboard -->
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
