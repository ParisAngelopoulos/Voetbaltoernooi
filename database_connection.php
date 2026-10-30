<?php
// The database is a SQLite file in private/ (not reachable from the web). The first time it is
// missing, it is created from private/database.sql with the example data, so no setup is needed.
$file = __DIR__ . '/private/database.sqlite';
$new = !is_file($file);

try {
    $db = new PDO('sqlite:' . $file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('PRAGMA foreign_keys = ON');
    if ($new) {
        $db->exec(file_get_contents(__DIR__ . '/private/database.sql'));
    }
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
