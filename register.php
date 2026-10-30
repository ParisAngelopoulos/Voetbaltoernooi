<?php
session_start();
require_once('layout.php');
vt_header('Team inschrijven');
?>
    <div class="max-w-lg mx-auto">
        <h1 class="text-3xl font-extrabold mb-2 text-center">Team inschrijven</h1>
        <p class="text-slate-400 text-center mb-6">Kies een teamnaam, een login en vul je vijf spelers in.</p>
        <form action="register_process.php" method="post" class="rounded-xl bg-slate-900 border border-slate-800 p-6 space-y-4">
            <label class="block"><span class="text-sm text-slate-300">Teamnaam</span>
                <input type="text" id="team_name" name="team_name" required class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" placeholder="Bijvoorbeeld: VV Ede">
            </label>
            <div class="grid grid-cols-2 gap-4">
                <label class="block"><span class="text-sm text-slate-300">Gebruikersnaam</span>
                    <input type="text" id="username" name="username" required class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand">
                </label>
                <label class="block"><span class="text-sm text-slate-300">Wachtwoord</span>
                    <input type="password" id="password" name="password" required class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand">
                </label>
            </div>
            <fieldset>
                <legend class="text-sm text-slate-300 mb-1">Spelers</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="text" id="player<?php echo $i; ?>" name="players[]" required class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" placeholder="Speler <?php echo $i; ?>">
                    <?php endfor; ?>
                </div>
            </fieldset>
            <button type="submit" class="w-full py-2.5 rounded-lg bg-brand font-semibold hover:bg-brand-dark">Inschrijven</button>
            <p class="text-center text-sm text-slate-400">Al ingeschreven? <a href="login.php" class="text-orange-400 hover:underline">Inloggen</a></p>
        </form>
    </div>
<?php vt_footer(); ?>
