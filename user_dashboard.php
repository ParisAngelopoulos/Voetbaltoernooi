<?php
session_start();
require_once('database_connection.php');
require_once('layout.php');
require_once('standings.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}

$teams = $db->query("SELECT * FROM teams")->fetchAll(PDO::FETCH_ASSOC);
$matches = $db->query("SELECT matches.match_id, teams1.team_name as team1_name, teams2.team_name as team2_name, matches.match_date, matches.team1_results, matches.team2_results FROM matches
                     JOIN teams as teams1 ON matches.team1_id = teams1.team_id
                     JOIN teams as teams2 ON matches.team2_id = teams2.team_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
// The team of the logged-in user, its players and its matches
$stmt = $db->prepare("SELECT teams.team_id, teams.team_name FROM teams JOIN users ON users.user_id = teams.user_id WHERE users.username = ?");
$stmt->execute([$_SESSION['username']]);
$myTeam = $stmt->fetch(PDO::FETCH_ASSOC);
$players = [];
$myMatches = [];
if ($myTeam) {
    $stmt = $db->prepare("SELECT player_name FROM players WHERE team_id = ? ORDER BY player_name");
    $stmt->execute([$myTeam['team_id']]);
    $players = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $myMatches = array_values(array_filter(all_matches($db), fn ($m) => in_array($myTeam['team_id'], [$m['team1_id'], $m['team2_id']])));
}
$next = current(array_filter($myMatches, fn ($m) => $m['team1_results'] === null)) ?: null;

vt_header('Mijn team');
?>
    <?php if ($myTeam): ?>
        <h1 class="text-3xl font-extrabold"><?php echo htmlspecialchars($myTeam['team_name']); ?></h1>
        <p class="text-slate-400 mt-1 mb-6">Welkom terug! Hier zie je je team, je wedstrijden en de ranglijst.</p>

        <div class="grid gap-4 md:grid-cols-3 mb-8">
            <section class="rounded-xl bg-slate-900 border border-slate-800 p-5">
                <h2 class="font-semibold mb-3">Spelers</h2>
                <ul class="space-y-1 text-sm">
                    <?php foreach ($players as $player): ?>
                        <li class="flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-brand/30 text-orange-300 text-xs flex items-center justify-center"><?php echo htmlspecialchars(mb_substr($player, 0, 1)); ?></span><?php echo htmlspecialchars($player); ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section class="md:col-span-2 rounded-xl bg-gradient-to-br from-brand/30 to-slate-900 border border-slate-800 p-5">
                <h2 class="font-semibold mb-3">Volgende wedstrijd</h2>
                <?php if ($next): ?>
                    <div class="text-sm text-slate-300"><?php echo htmlspecialchars(date('d-m-Y', strtotime($next['match_date']))); ?></div>
                    <div class="mt-2 text-2xl font-extrabold"><?php echo htmlspecialchars($next['team1_name']); ?> <span class="text-slate-400 font-normal">tegen</span> <?php echo htmlspecialchars($next['team2_name']); ?></div>
                <?php else: ?>
                    <p class="text-slate-300">Er staat geen wedstrijd meer gepland.</p>
                <?php endif; ?>
            </section>
        </div>
    <?php else: ?>
        <h1 class="text-3xl font-extrabold mb-6">Dashboard</h1>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        <section class="lg:col-span-2">
            <h2 class="text-xl font-bold mb-3">Ranglijst</h2>
            <?php standings_table($db, $myTeam['team_name'] ?? null); ?>
        </section>
        <section>
            <h2 class="text-xl font-bold mb-3">Jullie wedstrijden</h2>
            <?php match_list($myMatches); ?>
        </section>
    </div>
<?php vt_footer(); ?>
