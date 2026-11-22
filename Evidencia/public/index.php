<?php

declare(strict_types=1);

use App\Stav;
use App\Ulozisko;
use App\Zariadenie;

require __DIR__ . '/../vendor/autoload.php';

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

$ulozisko = new Ulozisko(__DIR__ . '/../data/zariadenia.json');
$zoznam = $ulozisko->nacitaj();

$chyby = [];
$nazov = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazov = trim($_POST['nazov'] ?? '');
    $stav = Stav::tryFrom($_POST['stav'] ?? '');

    if ($nazov === '') {
        $chyby[] = 'Názov je povinný.';
    } elseif (mb_strlen($nazov) > 50) {
        $chyby[] = 'Názov môže mať najviac 50 znakov.';
    }

    if ($stav === null) {
        $chyby[] = 'Neplatný stav.';
    }

    if ($chyby === []) {
        $zoznam->pridaj(new Zariadenie($nazov, $stav));
        $ulozisko->uloz($zoznam);

        header('Location: /');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Evidencia zariadení</title>
</head>
<body>
    <h1>Evidencia zariadení</h1>
    <p>Počet zariadení: <?= $zoznam->pocet() ?></p>

    <?php foreach ($chyby as $chyba): ?>
        <p style="color: red;"><?= e($chyba) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <label>Názov:
            <input type="text" name="nazov" value="<?= e($nazov) ?>">
        </label>
        <label>Stav:
            <select name="stav">
                <?php foreach (Stav::cases() as $s): ?>
                    <option value="<?= e($s->value) ?>"><?= e($s->popis()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Pridať</button>
    </form>

    <ul>
        <?php foreach ($zoznam->vsetky() as $z): ?>
            <li><?= e($z->nazov()) ?> (<?= e($z->stav()->popis()) ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>