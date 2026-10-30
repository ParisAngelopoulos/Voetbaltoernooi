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
    $team1Id = $_POST['team1'];
    $team2Id = $_POST['team2'];
    $matchDate = $_POST['match_date'];

    if ($team1Id === $team2Id) {
        $melding = "Een team kan niet tegen zichzelf spelen. Kies twee verschillende teams.";
    } else {
        $stmt = $db->prepare("INSERT INTO matches (team1_id, team2_id, match_date) VALUES (:team1_id, :team2_id, :match_date)");
        $stmt->bindParam(':team1_id', $team1Id);
        $stmt->bindParam(':team2_id', $team2Id);
        $stmt->bindParam(':match_date', $matchDate);

        try {
            $stmt->execute();
            $melding = "Wedstrijd succesvol gepland!";
        } catch (PDOException $e) {
            $melding = "Fout: " . $e->getMessage();
        }
    }
}

$stmtTeams = $db->query("SELECT * FROM teams");
$teams = $stmtTeams->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
$planned = array_values(array_filter(all_matches($db), fn ($m) => $m['team1_results'] === null));
vt_header('Wedstrijd plannen');
?>
    <div class="grid gap-8 md:grid-cols-2">
        <section>
            <h1 class="text-3xl font-extrabold mb-6">Wedstrijd plannen</h1>
            <?php vt_message($melding ?? '', strpos($melding ?? '', 'succesvol') !== false); ?>
            <form method="post" action="" class="rounded-xl bg-slate-900 border border-slate-800 p-6 space-y-4">
                <label class="block"><span class="text-sm text-slate-300">Thuisteam</span>
                    <select id="team1" name="team1" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?php echo $team['team_id']; ?>"><?php echo htmlspecialchars($team['team_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="block"><span class="text-sm text-slate-300">Uitteam</span>
                    <select id="team2" name="team2" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                        <?php foreach ($teams as $i => $team): ?>
                            <option value="<?php echo $team['team_id']; ?>" <?php echo $i === 1 ? 'selected' : ''; ?>><?php echo htmlspecialchars($team['team_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="block"><span class="text-sm text-slate-300">Datum</span>
                    <input type="date" id="match_date" name="match_date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                </label>
                <input type="submit" value="Wedstrijd plannen" class="w-full py-2.5 rounded-lg bg-brand font-semibold hover:bg-brand-dark cursor-pointer">
            </form>
        </section>
        <section>
            <h2 class="text-xl font-bold mb-3 md:mt-14">Al gepland</h2>
            <?php match_list($planned); ?>
        </section>
    </div>
<?php vt_footer(); ?>
