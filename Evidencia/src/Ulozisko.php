<?php

declare(strict_types=1);

namespace App;

final class Ulozisko
{
    public function __construct(private readonly string $cesta) {}

    public function nacitaj(): ZoznamZariadeni
    {
        $zoznam = new ZoznamZariadeni();

        if (!is_file($this->cesta)) {
            return $zoznam;
        }

        $json = file_get_contents($this->cesta);
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        foreach ($data as $polozka) {
            $zoznam->pridaj(
                new Zariadenie($polozka['nazov'], Stav::from($polozka['stav']))
            );
        }

        return $zoznam;
    }

    public function uloz(ZoznamZariadeni $zoznam): void
    {
        $data = array_map(
            fn (Zariadenie $z): array => [
                'nazov' => $z->nazov(),
                'stav' => $z->stav()->value,
            ],
            $zoznam->vsetky()
        );

        file_put_contents(
            $this->cesta,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
        );
    }
}