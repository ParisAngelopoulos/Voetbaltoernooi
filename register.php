<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CDN -->
    <title>Spelerregistratie</title>
</head>
<body class="bg-black text-white">

    <!-- Hoofdtitel -->
    <div class="flex justify-center mt-10">
        <h2 class="text-3xl sm:text-5xl font-bold text-white">Spelerregistratie</h2>
    </div>

    <!-- Registratieformulier -->
    <div class="max-w-lg mx-auto mt-10 bg-gray-800 p-6 rounded-lg shadow-lg">
        <form action="register_process.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-lg">Gebruikersnaam:</label>
                <input type="text" id="username" name="username" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="password" class="block text-lg">Wachtwoord:</label>
                <input type="password" id="password" name="password" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="team_name" class="block text-lg">Teamnaam:</label>
                <input type="text" id="team_name" name="team_name" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <!-- Spelersvelden -->
            <div>
                <label for="player1" class="block text-lg">Speler 1:</label>
                <input type="text" id="player1" name="players[]" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="player2" class="block text-lg">Speler 2:</label>
                <input type="text" id="player2" name="players[]" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="player3" class="block text-lg">Speler 3:</label>
                <input type="text" id="player3" name="players[]" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="player4" class="block text-lg">Speler 4:</label>
                <input type="text" id="player4" name="players[]" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label for="player5" class="block text-lg">Speler 5:</label>
                <input type="text" id="player5" name="players[]" required class="w-full p-2 mt-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <input type="submit" value="Registreren" class="w-full py-3 mt-4 bg-orange-500 text-white font-bold rounded hover:bg-orange-600 transition">
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-gray-900 text-center text-white py-4 mt-auto">
        <p>&copy; 2025 Voetbaltoernooi. Alle rechten voorbehouden.</p>
    </footer>

</body>
</html>
