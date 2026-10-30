<?php
session_start();
// Alleen de admin mag deze pagina gebruiken
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
require_once('database_connection.php');
require_once('layout.php');

$teams = $db->query("SELECT * FROM teams")->fetchAll(PDO::FETCH_ASSOC);
$matches = $db->query("SELECT matches.match_id, teams1.team_name as team1_name, teams2.team_name as team2_name, matches.match_date, matches.team1_results, matches.team2_results FROM matches
                     JOIN teams as teams1 ON matches.team1_id = teams1.team_id
                     JOIN teams as teams2 ON matches.team2_id = teams2.team_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
$players = [];
foreach ($db->query("SELECT team_id, player_name FROM players ORDER BY player_name") as $p) {
    $players[$p['team_id']][] = $p['player_name'];
}
vt_header('Teams');
?>
    <h1 class="text-3xl font-extrabold mb-6">Teams <span class="text-slate-500 font-normal text-xl">(<?php echo count($teams); ?>)</span></h1>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($teams as $team): ?>
            <section class="rounded-xl bg-slate-900 border border-slate-800 p-5">
                <h2 class="font-bold text-lg"><?php echo htmlspecialchars($team['team_name']); ?></h2>
                <p class="text-xs text-slate-500 mb-3"><?php echo count($players[$team['team_id']] ?? []); ?> spelers</p>
                <ul class="text-sm space-y-1 text-slate-300">
                    <?php foreach ($players[$team['team_id']] ?? [] as $player): ?>
                        <li>• <?php echo htmlspecialchars($player); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    </div>
<?php vt_footer(); ?>
