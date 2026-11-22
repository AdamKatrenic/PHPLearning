<?php

declare(strict_types=1);

namespace App;

final class Zariadenie
{
    public function __construct(
        private string $nazov,
        private Stav $stav,
    ) {}

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
}