<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

final class Zariadenie
{
    private string $nazov;

    public function __construct(
        string $nazov,
        private Stav $stav,
    ) {
        $cistyNazov = trim($nazov);
        if ($cistyNazov === '') {
            throw new InvalidArgumentException('Názov zariadenia nesmie byť prázdny.');
        }

        $this->nazov = $cistyNazov;
    }

    public function nazov(): string
    {
        return $this->nazov;
    }

    public function stav(): Stav
    {
        return $this->stav;
    }

    public function jeOnline(): bool
    {
        return $this->stav === Stav::Online;
    }

    public function zmenStav(Stav $novyStav): void
    {
        $this->stav = $novyStav;
    }
}