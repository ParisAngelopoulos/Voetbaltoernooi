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
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Speler Dashboard</title>
    <style>
        table {
            cursor: pointer;
        }
    </style>
    <script>
    $(document).ready(function(){
        $('table').on('click', 'td.team-name', function(){
            var teamName = $(this).text();
            $.ajax({
                type: 'POST',
                url: 'get_players.php',
                data: {team_name: teamName},
                dataType: 'json',
                success: function(response){
                    console.log('Team name:', teamName);
                    if (response.length > 0) {
                        var queryString = '?team=' + encodeURIComponent(teamName);
                        var newPageUrl = 'get_players.php' + queryString;
                        window.location.href = newPageUrl;
                    } else {
                        alert('Geen spelers gevonden voor ' + teamName);
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

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
                        <td class="team-name"><?= $team['team_name']; ?></td>
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
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Wedstrijddatum</th>
                    <th>Team 1 Resultaten</th>
                    <th>Team 2 Resultaten</th>
                </tr>
                <?php foreach ($matches as $match): ?>
                    <tr>
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

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
</body>
</html>
