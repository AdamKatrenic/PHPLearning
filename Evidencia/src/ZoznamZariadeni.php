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
        return array_values(
            array_filter($this->zariadenia, fn (Zariadenie $z): bool => !$z->jeOnline())
        );
    }

    public function pocet(): int
    {
        return count($this->zariadenia);
    }
}