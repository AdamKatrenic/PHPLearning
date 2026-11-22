<?php

declare(strict_types=1);

namespace App;

enum Stav: string
{
    case Online = 'online';
    case Offline = 'offline';
    case Porucha = 'porucha';

    public function popis(): string
    {
        return match ($this) {
            self::Online => 'beží',
            self::Offline => 'nebeží',
            self::Porucha => 'má poruchu',
        };
    }
}