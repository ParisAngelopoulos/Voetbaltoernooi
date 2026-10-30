<?php
// Shared page layout: header with a menu that depends on who is logged in, and the footer
function vt_header($title) {
    $role = $_SESSION['role'] ?? null;
    $page = basename($_SERVER['PHP_SELF']);
    $links = $role === 'admin'
        ? ['admin_.php' => 'Dashboard', 'view_teams.php' => 'Teams', 'plan_matches.php' => 'Wedstrijd plannen', 'enter_results.php' => 'Uitslagen']
        : ($role === 'user' ? ['user_dashboard.php' => 'Mijn team'] : ['index.php' => 'Ranglijst', 'register.php' => 'Team inschrijven']);
    ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> · Voetbaltoernooi</title>
    <link rel="stylesheet" href="css/tailwind.css">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">
    <header class="bg-slate-900 border-b border-slate-800">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <a href="index.php" class="flex items-center gap-2 text-xl font-extrabold"><span class="text-2xl">⚽</span> Voetbaltoernooi</a>
            <nav class="flex flex-wrap items-center gap-1 text-sm">
                <?php foreach ($links as $file => $label): ?>
                    <a href="<?php echo $file; ?>" class="px-3 py-1.5 rounded-lg <?php echo $page === $file ? 'bg-brand text-white' : 'text-slate-300 hover:text-white'; ?>"><?php echo $label; ?></a>
                <?php endforeach; ?>
                <?php if ($role): ?>
                    <span class="ml-2 text-slate-400"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="ml-2 px-3 py-1.5 rounded-lg border border-slate-700 text-slate-300 hover:text-white">Uitloggen</a>
                <?php else: ?>
                    <a href="login.php" class="ml-2 px-3 py-1.5 rounded-lg bg-brand text-white font-semibold hover:bg-brand-dark">Inloggen</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="max-w-5xl w-full mx-auto px-4 py-8 flex-1">
    <?php
}

function vt_footer() {
    ?>
    </main>
    <footer class="border-t border-slate-800 py-6 text-center text-sm text-slate-500">
        &copy; <?php echo date('Y'); ?> Voetbaltoernooi · een project van <a href="https://parisangelopoulos.com" class="underline hover:text-slate-300">Paris Angelopoulos</a>
    </footer>
</body>
</html>
    <?php
}

// A message on the page (after planning a match or entering a result)
function vt_message($text, $good = true) {
    if (!$text) return;
    $colors = $good ? 'bg-emerald-950 border-emerald-800 text-emerald-200' : 'bg-red-950 border-red-800 text-red-200';
    echo '<div class="mb-6 rounded-lg border px-4 py-3 ' . $colors . '">' . htmlspecialchars($text) . '</div>';
}
