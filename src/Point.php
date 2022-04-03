<?php

declare(strict_types=1);

class Point {
    private int $x;
    private int $y;
    private array $coord;

    public function __construct(bool $rest = false)
    {
        if ($rest == true) {
            $this->x = 2500;
            $this->y = 2500;
        } else {
            $this->x = rand(0, 5000);
            $this->y = rand(0, 5000);
        }
        $this->coord = [$this->x, $this->y];
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getCoord(): array
    {
        return $this->coord;
    }

    public static function getDistanceBetweenPoint($lat1, $lng1, $lat2, $lng2): float
    {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $meter = ($earth_radius * $d);
        return $meter;
    }
}