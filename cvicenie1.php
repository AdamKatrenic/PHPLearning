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

final class Produkt
{
    public function __construct(
        public readonly string $nazov,
        public readonly float $cena,
        public readonly int $pocet,
        public readonly Kategoria $kategoria
    ) {
        if ($cena < 0) {
            throw new InvalidArgumentException("Cena nesmie byť záporná");
        }
        if ($pocet < 0) {
            throw new InvalidArgumentException("Počet nesmie byť záporný");
        }
    }

    public function celkovaCena(): float
    {
        return $this->cena * $this->pocet;
    }

}

$p = new Produkt("Škridla", 2.5, 100, Kategoria::Material);
echo $p->celkovaCena(); // 250