<?php
// League table from the played matches: 3 points for a win, 1 for a draw.
// Sorted by points, then goal difference, then goals scored.
function standings(PDO $db) {
    $table = [];
    foreach ($db->query("SELECT team_id, team_name FROM teams") as $team) {
        $table[$team['team_id']] = ['team' => $team['team_name'], 'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0, 'for' => 0, 'against' => 0, 'points' => 0];
    }
    $played = $db->query("SELECT team1_id, team2_id, team1_results, team2_results FROM matches WHERE team1_results IS NOT NULL AND team2_results IS NOT NULL");
    foreach ($played as $m) {
        foreach ([[$m['team1_id'], $m['team1_results'], $m['team2_results']], [$m['team2_id'], $m['team2_results'], $m['team1_results']]] as [$id, $for, $against]) {
            if (!isset($table[$id])) continue;
            $row = &$table[$id];
            $row['played']++;
            $row['for'] += $for;
            $row['against'] += $against;
            if ($for > $against) { $row['won']++; $row['points'] += 3; }
            elseif ($for == $against) { $row['drawn']++; $row['points'] += 1; }
            else { $row['lost']++; }
            unset($row);
        }
    }
    usort($table, fn ($a, $b) => [$b['points'], $b['for'] - $b['against'], $b['for']] <=> [$a['points'], $a['for'] - $a['against'], $a['for']]);
    return $table;
}

// The league table as HTML; $highlight is the name of a team to mark (your own team)
function standings_table(PDO $db, $highlight = null) {
    ?>
    <div class="overflow-x-auto rounded-xl border border-slate-800">
        <table class="w-full text-sm">
            <thead class="bg-slate-900 text-slate-400">
                <tr><th class="p-3 text-left">#</th><th class="p-3 text-left">Team</th><th class="p-3">G</th><th class="p-3">W</th><th class="p-3">GL</th><th class="p-3">V</th><th class="p-3">Doelsaldo</th><th class="p-3">Punten</th></tr>
            </thead>
            <tbody>
                <?php foreach (standings($db) as $i => $row): ?>
                    <tr class="border-t border-slate-800 <?php echo $row['team'] === $highlight ? 'bg-brand/20' : 'hover:bg-slate-900'; ?>">
                        <td class="p-3 text-slate-400"><?php echo $i + 1; ?></td>
                        <td class="p-3 font-semibold"><?php echo htmlspecialchars($row['team']); ?></td>
                        <td class="p-3 text-center"><?php echo $row['played']; ?></td>
                        <td class="p-3 text-center"><?php echo $row['won']; ?></td>
                        <td class="p-3 text-center"><?php echo $row['drawn']; ?></td>
                        <td class="p-3 text-center"><?php echo $row['lost']; ?></td>
                        <td class="p-3 text-center"><?php $d = $row['for'] - $row['against']; echo ($d > 0 ? '+' : '') . $d; ?></td>
                        <td class="p-3 text-center font-bold text-orange-400"><?php echo $row['points']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="text-xs text-slate-500 mt-2">G = gespeeld, W = gewonnen, GL = gelijk, V = verloren</p>
    <?php
}

// Matches as a list of cards: played ones with the score, planned ones with "gepland"
function match_list($matches) {
    if (!$matches) {
        echo '<p class="text-slate-400">Nog geen wedstrijden.</p>';
        return;
    }
    echo '<div class="space-y-2">';
    foreach ($matches as $m) {
        $played = $m['team1_results'] !== null && $m['team2_results'] !== null;
        echo '<div class="rounded-lg bg-slate-900 border border-slate-800 px-4 py-2.5 text-sm">';
        echo '<div class="text-xs text-slate-500 mb-1">' . htmlspecialchars(date('d-m-Y', strtotime($m['match_date']))) . '</div>';
        echo '<div class="flex items-center gap-3">';
        echo '<span class="flex-1 min-w-0 text-right font-medium leading-tight">' . htmlspecialchars($m['team1_name']) . '</span>';
        echo $played
            ? '<span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-md bg-slate-800 font-bold tabular-nums">' . (int)$m['team1_results'] . ' – ' . (int)$m['team2_results'] . '</span>'
            : '<span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-md bg-brand/20 text-orange-300 text-xs">gepland</span>';
        echo '<span class="flex-1 min-w-0 font-medium leading-tight">' . htmlspecialchars($m['team2_name']) . '</span>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

// All matches with team names, planned ones first by date
function all_matches(PDO $db) {
    return $db->query("SELECT matches.*, t1.team_name AS team1_name, t2.team_name AS team2_name
                       FROM matches
                       JOIN teams t1 ON matches.team1_id = t1.team_id
                       JOIN teams t2 ON matches.team2_id = t2.team_id
                       ORDER BY matches.match_date")->fetchAll(PDO::FETCH_ASSOC);
}
