<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Beheerdersdashboard</title>
</head>
<body class="bg-black text-white font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 text-white p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-center">Beheerdersdashboard</h1>
    </header>

    <!-- Main content -->
    <main class="flex-1 container mx-auto p-8">

        <!-- Welkomstbericht -->
        <h2 class="text-3xl font-semibold mb-6 text-center text-blue-500">Welkom, Admin!</h2>

        <!-- Acties menu -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="view_teams.php" class="block bg-blue-600 text-white p-6 rounded-lg shadow-xl hover:bg-blue-700 transition transform hover:scale-105">
                <h3 class="text-2xl font-semibold mb-4">Teams bekijken</h3>
                <p class="text-lg">Bekijk de lijst van alle teams.</p>
            </a>

            <a href="plan_matches.php" class="block bg-blue-600 text-white p-6 rounded-lg shadow-xl hover:bg-blue-700 transition transform hover:scale-105">
                <h3 class="text-2xl font-semibold mb-4">Wedstrijden plannen</h3>
                <p class="text-lg">Plan nieuwe wedstrijden tussen teams.</p>
            </a>

            <a href="enter_results.php" class="block bg-blue-600 text-white p-6 rounded-lg shadow-xl hover:bg-blue-700 transition transform hover:scale-105">
                <h3 class="text-2xl font-semibold mb-4">Uitslagen invoeren</h3>
                <p class="text-lg">Voer de resultaten van de gespeelde wedstrijden in.</p>
            </a>
        </div>

        <!-- Uitlogknop -->
        <p class="mt-6 text-center">
            <a href="logout.php" class="text-blue-600 hover:underline text-lg">Uitloggen</a>
        </p>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center mt-12">
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi. Alle rechten voorbehouden.</p>
    </footer>

</body>
</html>
