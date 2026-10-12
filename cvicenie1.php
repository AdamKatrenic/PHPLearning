<?php

declare(strict_types=1);

final class Produkt
{
    public function __construct(
        public readonly string $nazov,
        public readonly float $cena,
        public readonly int $pocet,
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

$p = new Produkt("Škridla", 2.5, 100);
echo $p->celkovaCena(); // 250