<?php
session_start();
?>
<?php
require_once('layout.php');
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
vt_header('Inloggen');
?>
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-extrabold mb-6 text-center">Inloggen</h1>
        <?php vt_message($error, false); ?>
        <div class="rounded-xl bg-slate-900 border border-slate-800 p-6">
            <form method="post" action="login_process.php" class="space-y-4">
                <div>
                    <label for="username" class="text-sm text-slate-300">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                </div>

                <div>
                    <label for="password" class="text-sm text-slate-300">Wachtwoord</label>
                    <input type="password" name="password" id="password" class="w-full mt-1 p-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand" required>
                </div>

                <div class="text-center">
                    <input type="submit" value="Log in" class="w-full py-2.5 rounded-lg bg-brand font-semibold hover:bg-brand-dark cursor-pointer">
                </div>
            </form>
            <p class="mt-4 text-center text-sm text-slate-400">Nog geen team? <a href="register.php" class="text-orange-400 hover:underline">Schrijf je team in</a></p>
            <!-- Testaccounts, zodat bezoekers zonder registreren kunnen rondkijken -->
            <div class="mt-6 p-4 bg-slate-800 border border-slate-700 rounded-lg text-sm">
                <p class="font-semibold mb-2">Even rondkijken? Kies een testaccount:</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="vulIn('admin', 'admin123')" class="px-3 py-1 bg-slate-900 border border-slate-600 rounded-full hover:border-brand">admin (beheer)</button>
                    <button type="button" onclick="vulIn('fcveenendaal', 'welkom123')" class="px-3 py-1 bg-slate-900 border border-slate-600 rounded-full hover:border-brand">FC Veenendaal (team)</button>
                </div>
                <p class="text-slate-400 mt-2">Admin: <code>admin123</code>, teams: <code>welkom123</code>. Als admin plan je wedstrijden en vul je uitslagen in.</p>
            </div>
            <script>
                function vulIn(gebruiker, wachtwoord) {
                    document.getElementById('username').value = gebruiker;
                    document.getElementById('password').value = wachtwoord;
                }
            </script>
        </div>
    </div>
<?php vt_footer(); ?>
