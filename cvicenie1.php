<?php

declare(strict_types=1);

enum Kategoria: string
{
    case Strecha = "strecha";
    case Naradie = "naradie";
    case Material = "material";

    public function popis(): string
    {
        return match($this) {
            self::Strecha => "Strešné prvky a krytina",
            self::Naradie => "Ručné a elektrické náradie",
            self::Material => "Stavebný materiál",
        };
    }
}

final class Produkt implements Cenovka
{
    public function __construct(
        public readonly string $nazov,
        public readonly float $cena,
        public readonly int $mnozstvo,
        public readonly Kategoria $kategoria
    ) {
        if ($cena < 0) {
            throw new InvalidArgumentException("Cena nesmie byť záporná");
        }
        if ($mnozstvo < 0) {
            throw new InvalidArgumentException("Množstvo nesmie byť záporné");
        }
    }

    public function celkovaCena(): float
    {
        return $this->cena * $this->mnozstvo;
    }

}

final class Sluzba implements Cenovka
{
    public function __construct(
        public readonly string $nazov,
        public readonly float $hodinovaSadzba,
        public readonly int $pocetHodin,
    ) {
        if ($hodinovaSadzba < 0) {
            throw new InvalidArgumentException("Sadzba nesmie byť záporná");
        }
        if ($pocetHodin < 0) {
            throw new InvalidArgumentException("Počet hodín nesmie byť záporný");
        }
    }

    public function celkovaCena(): float
    {
        return $this->hodinovaSadzba * $this->pocetHodin;
    }
}

interface Cenovka
{
    public function celkovaCena(): float;
}

function sucetCien(array $produkty): float
{
    return array_sum(
        array_map(fn (Cenovka $p): float => $p->celkovaCena(), $produkty)
    );
}

$p1 = new Produkt("Škridla", 2.5, 100, Kategoria::Material);
$p2 = new Produkt("Flexa", 250.0, 2, Kategoria::Naradie);
$p3 = new Produkt("Strecha", 10000.0, 100, Kategoria::Strecha);
$p4 = new Produkt("Laty", 6.7, 500, Kategoria::Material);

$produkty = [$p1, $p2, $p3, $p4];

$material = array_filter(
    $produkty,
    fn (Produkt $p): bool => $p->kategoria === Kategoria::Material
);

$nazvy = array_map(fn (Produkt $p): string => $p->nazov, $material);

$celkom = sucetCien($produkty);

echo implode(", ", $nazvy) . "\n";   // Škridla, Laty
echo $celkom . "\n";                 // 1003600

$montaz = new Sluzba("Montáž strechy", 25.0, 40);
echo $montaz->celkovaCena() . "\n";  // 1000