<?php
session_start();
require_once('database_connection.php');
require_once('layout.php');
require_once('standings.php');

$matches = all_matches($db);
$planned = array_values(array_filter($matches, fn ($m) => $m['team1_results'] === null));
$played = array_reverse(array_values(array_filter($matches, fn ($m) => $m['team1_results'] !== null)));

vt_header('Ranglijst');
?>
    <section class="relative overflow-hidden rounded-2xl mb-8 bg-cover bg-center" style="background-image: url('image.jpg');">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 to-slate-950/40"></div>
        <div class="relative px-6 py-14 sm:px-10">
            <h1 class="text-4xl sm:text-5xl font-extrabold">Voetbaltoernooi 2025</h1>
            <p class="mt-3 text-slate-300 max-w-xl">Zes teams, één beker. Volg de ranglijst, de uitslagen en de wedstrijden die nog komen.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="register.php" class="px-5 py-2.5 rounded-lg bg-brand font-semibold hover:bg-brand-dark">Schrijf je team in</a>
                <a href="login.php" class="px-5 py-2.5 rounded-lg bg-white/10 border border-white/20 font-semibold hover:bg-white/20">Inloggen</a>
            </div>
        </div>
    </section>

    <div class="grid gap-8 lg:grid-cols-3">
        <section class="lg:col-span-2">
            <h2 class="text-xl font-bold mb-3">Ranglijst</h2>
            <?php standings_table($db); ?>
        </section>
        <section>
            <h2 class="text-xl font-bold mb-3">Komende wedstrijden</h2>
            <?php match_list($planned); ?>
            <h2 class="text-xl font-bold mt-8 mb-3">Laatste uitslagen</h2>
            <?php match_list(array_slice($played, 0, 4)); ?>
        </section>
    </div>
<?php vt_footer(); ?>
