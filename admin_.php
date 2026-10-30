<?php
session_start();
require_once('database_connection.php');
require_once('layout.php');
require_once('standings.php');
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<?php
$matches = all_matches($db);
$planned = array_values(array_filter($matches, fn ($m) => $m['team1_results'] === null));
$counts = [
    'Teams' => $db->query("SELECT COUNT(*) FROM teams")->fetchColumn(),
    'Spelers' => $db->query("SELECT COUNT(*) FROM players")->fetchColumn(),
    'Gespeeld' => count($matches) - count($planned),
    'Gepland' => count($planned),
];
vt_header('Beheer');
?>
    <h1 class="text-3xl font-extrabold">Beheerdersdashboard</h1>
    <p class="text-slate-400 mt-1 mb-6">Plan wedstrijden, vul uitslagen in en houd de ranglijst bij.</p>

    <div class="grid gap-4 grid-cols-2 md:grid-cols-4 mb-8">
        <?php foreach ($counts as $label => $count): ?>
            <div class="rounded-xl bg-slate-900 border border-slate-800 p-4">
                <div class="text-3xl font-extrabold text-orange-400"><?php echo (int)$count; ?></div>
                <div class="text-sm text-slate-400"><?php echo $label; ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="grid gap-4 md:grid-cols-3 mb-10">
        <?php foreach ([['view_teams.php', 'Teams bekijken', 'Alle teams met hun spelers.', '👥'], ['plan_matches.php', 'Wedstrijd plannen', 'Zet een nieuwe wedstrijd op het schema.', '📅'], ['enter_results.php', 'Uitslag invoeren', 'Vul de score van een wedstrijd in.', '🏆']] as [$href, $title, $text, $icon]): ?>
            <a href="<?php echo $href; ?>" class="rounded-xl bg-slate-900 border border-slate-800 p-5 hover:border-brand hover:bg-slate-800 transition">
                <div class="text-2xl"><?php echo $icon; ?></div>
                <div class="mt-2 font-semibold text-lg"><?php echo $title; ?></div>
                <div class="text-sm text-slate-400"><?php echo $text; ?></div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <section class="lg:col-span-2">
            <h2 class="text-xl font-bold mb-3">Ranglijst</h2>
            <?php standings_table($db); ?>
        </section>
        <section>
            <h2 class="text-xl font-bold mb-3">Nog te spelen</h2>
            <?php match_list($planned); ?>
        </section>
    </div>
<?php vt_footer(); ?>
