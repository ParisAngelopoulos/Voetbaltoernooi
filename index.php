<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Voetbaltoernooi</title>
</head>
<body class="bg-black text-white">

    <!-- Navigatiebalk -->
    <ul class="flex justify-center space-x-8 bg-gray-900 p-4">
        <li><a href="register.php" class="text-lg hover:text-orange-400 transition">Register</a></li>
        <li><a href="login.php" class="text-lg hover:text-orange-400 transition">Log in</a></li>
    </ul>

    <!-- Achtergrondafbeelding in de body -->
    <div class="relative w-full h-screen bg-cover bg-center" style="background-image: url('image.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div> <!-- Overlay voor betere leesbaarheid -->

        <div class="relative flex justify-center items-center h-full">
            <h1 class="text-4xl sm:text-6xl font-bold text-white text-center shadow-lg">
                Welkom bij het Voetbaltoernooi!
            </h1>
        </div>
    </div>

</body>
</html>
