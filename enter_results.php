<?php
session_start();
// Alleen de admin mag deze pagina gebruiken
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
require_once('database_connection.php');
require_once('layout.php');
require_once('standings.php');

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
<?php
vt_header('Uitslag invoeren');
?>
    <div class="grid gap-8 md:grid-cols-2">
        <section>
            <h1 class="text-3xl font-extrabold mb-6">Uitslag invoeren</h1>
            <?php vt_message($melding ?? '', strpos($melding ?? '', 'succesvol') !== false); ?>
            <form method="post" action="" class="rounded-xl bg-slate-900 border border-slate-800 p-6 space-y-4">
                <label class="block"><span class="text-sm text-slate-300">Wedstrijd</span>
                    <select id="match_id" name="match_id" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                        <?php foreach ($matches as $match): ?>
                            <option value="<?php echo $match['match_id']; ?>"><?php echo htmlspecialchars(date('d-m', strtotime($match['match_date'])) . ': ' . $match['team1_name'] . ' – ' . $match['team2_name']); ?><?php if ($match['team1_results'] !== null) echo ' (' . $match['team1_results'] . '-' . $match['team2_results'] . ')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="block"><span class="text-sm text-slate-300">Doelpunten thuisteam</span>
                        <input type="number" id="team1_results" name="team1_results" min="0" value="0" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                    </label>
                    <label class="block"><span class="text-sm text-slate-300">Doelpunten uitteam</span>
                        <input type="number" id="team2_results" name="team2_results" min="0" value="0" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                    </label>
                </div>
                <input type="submit" value="Uitslag opslaan" class="w-full py-2.5 rounded-lg bg-brand font-semibold hover:bg-brand-dark cursor-pointer">
            </form>
        </section>
        <section>
            <h2 class="text-xl font-bold mb-3 md:mt-14">Ranglijst</h2>
            <?php standings_table($db); ?>
        </section>
    </div>
<?php vt_footer(); ?>
