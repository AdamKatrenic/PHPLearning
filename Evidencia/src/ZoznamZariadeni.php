<?php

declare(strict_types=1);

namespace App;

final class ZoznamZariadeni
{
    /** @var list<Zariadenie> */
    private array $zariadenia = [];

    public function pridaj(Zariadenie $zariadenie): void
    {
        $this->zariadenia[] = $zariadenie;
    }

    /** @return list<Zariadenie> */
    public function vsetky(): array
    {
        return $this->zariadenia;
    }

    /** @return list<Zariadenie> */
    public function offline(): array
    {
        return $this->podlaStavu(Stav::Offline);
    }

    public function pocet(): int
    {
        return count($this->zariadenia);
    }

        /** @return list<Zariadenie> */
    public function podlaStavu(Stav $stav): array
    {
        return array_values(
            array_filter(
                $this->zariadenia,
                fn (Zariadenie $z): bool => $z->stav() === $stav
            )
        );
    }

    /** @return list<Zariadenie> */
    public function poruchove(): array
    {
        return $this->podlaStavu(Stav::Porucha);
    }
}