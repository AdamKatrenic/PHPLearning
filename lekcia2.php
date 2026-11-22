<?php

declare(strict_types=1);

class Zariadenie
{
    public function __construct(
        private string $nazov,
        private string $ip,
        private string $stav,
        private ?string $lokalita = null
    ) {}

    public function jeOnline(): bool
    {
        return $this->stav === "online";
    }

    public function getNazov(): string
    {
        return $this->nazov;
    }

    public function getLokalita(): ?string
    {
        return $this->lokalita ?? "Neznáma";
    }
}

$z1 = new Zariadenie("AP-01", "192.168.1.1", "online");
$z2 = new Zariadenie("AP-02", "192.168.1.2", "offline", "Záborksé");
$z3 = new Zariadenie("AP-03", "192.168.1.3", "online", "ITcity");
$z4 = new Zariadenie("AP-04", "192.168.1.4", "offline");
$z5 = new Zariadenie("AP-05", "192.168.1.5", "online");

$Zariadenia = [$z1, $z2, $z3, $z4, $z5];

echo "\nStav zariadení:\n\n";

foreach ($Zariadenia as $ap) {
    if ($ap->jeOnline()) {
        echo "Zariadenie " . $ap->getNazov() . " je online.\n";
    } else {
        echo "Zariadenie " . $ap->getNazov() . " je offline.\n";
    }
}

echo "\nOffline zariadenia:\n\n";

$offlineZariadenia = offlineZariadenia($Zariadenia);

function offlineZariadenia(array $zariadenia): array
{
    return array_filter($zariadenia, function ($zariadenie) {
        return !$zariadenie->jeOnline();
    });
}

foreach ($offlineZariadenia as $ap) {
    echo "Zariadenie " . $ap->getNazov() . " ( " . $ap->getLokalita() . " ) je offline.\n";
}

echo "\nNázvy zariadení: ";

function nazvyZariadeni(array $zariadenia): array
{
    return array_map(function ($zariadenie) {
        return $zariadenie->getNazov();
    }, $zariadenia);
}

$nazvy = nazvyZariadeni($Zariadenia);

foreach ($nazvy as $nazov) {
    echo $nazov . ", ";
}

