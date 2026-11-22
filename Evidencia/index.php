<?php

declare(strict_types=1);

use App\Stav;
use App\Zariadenie;
use App\ZoznamZariadeni;

require __DIR__ . '/vendor/autoload.php';

$zoznam = new ZoznamZariadeni();

$zariadenie1 = new Zariadenie('Router hlavný', Stav::Online);
$zariadenie2 = new Zariadenie('Tlačiareň recepcia', Stav::Offline);
$zariadenie3 = new Zariadenie('Senzor teploty sklad', Stav::Porucha);

$zoznam->pridaj($zariadenie1);
$zoznam->pridaj($zariadenie2);
$zoznam->pridaj($zariadenie3);

echo 'Počet zariadení: ' . $zoznam->pocet() . PHP_EOL;

foreach ($zoznam->vsetky() as $z) {
    echo sprintf('- %s (%s)' . PHP_EOL, $z->nazov(), $z->stav()->popis());
}

echo 'Počet offline zariadení: ' . count($zoznam->offline()) . PHP_EOL;