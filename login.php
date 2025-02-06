<?php
session_start();
if (isset($_SESSION['error'])) {
    echo '<p class="text-red-500 text-center mb-4">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']); // Verwijder de foutmelding na weergave
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Log in</title>
</head>

<body class="bg-black text-white font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 text-white p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-center">Log in</h1>
    </header>

    <!-- Main content -->
    <main class="flex-1 flex items-center justify-center p-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">

            <h2 class="text-3xl font-semibold text-center text-blue-500 mb-6">Inloggen</h2>

            <!-- Login form -->
            <form method="post" action="login_process.php" class="space-y-4">
                <div>
                    <label for="username" class="block text-lg">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" class="w-full p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="password" class="block text-lg">Wachtwoord</label>
                    <input type="password" name="password" id="password" class="w-full p-3 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="text-center">
                    <input type="submit" value="Log in" class="w-full p-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="register.php" class="text-blue-600 hover:underline">Registreer hier</a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center mt-12">
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>

</body>
</html>
