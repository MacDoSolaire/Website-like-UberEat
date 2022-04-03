<?php

declare(strict_types=1);

class Graph {
    private array $mapArray;
    private array $commande;
    private array $path;
    private array $arbre;

    public const RESTO_COORD = ['lat' => 49.254923, 'lon' => 4.0272211];

    public function __construct(array $arrayId)
    {
        $this->mapArray = array(
            [0, 0, 0, 0, 0, 0], // Resto
            [0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0]
        );

        $this->commande = array(
            0 => self::RESTO_COORD
        );


        for ($i=1; $i <= 5; $i++) {
            $gmap = new GmapApi();
            $json = json_decode($gmap->geoLoc($arrayId[$i - 1]), true);
            sleep(1);
            $this->commande[$i] = array('lat' => (float) $json[0]['lat'], 'lon' =>(float) $json[0]['lon']);
        }
    }

    public function fillMap(): void
    {
        for ($i=0; $i < count($this->mapArray); $i++) {
            for ($j=0; $j < 6; $j++) {
                $dist = Point::getDistanceBetweenPoint(
                    $this->commande[$i]['lat'], 
                    $this->commande[$i]['lon'],
                    $this->commande[$j]['lat'],
                    $this->commande[$j]['lon']);
                $this->mapArray[$i][$j] = $dist;
            }
        }
    }

    public function getDistanceTrajet(): float
    {
        $dist = 0;
        for($i=0; $i < count($this->path); $i++) {
            if ($i == count($this->path)-1) {
                $dist += Point::getDistanceBetweenPoint(
                    $this->commande[$this->path[$i - 1]]['lat'],
                    $this->commande[$this->path[$i - 1]]['lon'],
                    $this->commande[$this->path[$i]]['lat'],
                    $this->commande[$this->path[$i]]['lon']);
            } else {
                $dist += Point::getDistanceBetweenPoint(
                    $this->commande[$this->path[$i]]['lat'],
                    $this->commande[$this->path[$i]]['lon'],
                    $this->commande[$this->path[$i + 1]]['lat'],
                    $this->commande[$this->path[$i + 1]]['lon']);
            }
        }
        return $dist;
    }

    public function getMapArray(): array
    {
        return $this->mapArray;
    }

    public function getPath(): array
    {
        return $this->path;
    }

    public function getCommandeArray(): array
    {
        return $this->commande;
    }

    public function glouton(): void
    {
        $array = $this->mapArray;

        $mini = 100000000;
        $y = 0;
        $somNonMarque = [1, 2, 3, 4, 5];
        $path = array(0);

        while (count($path) != count($somNonMarque) + 1) {
            $mini = 100000000;

            for ($j = 0; $j < count($somNonMarque); $j++) {
                $somX = $path[count($path) - 1];
                $somY = $somNonMarque[$j];

                if (!in_array($somY, $path) && $array[$somX][$somY] < $mini) {
                    $mini = $array[$somX][$somY];
                    $y = $somY;
                }
            }
            array_push($path, $y);
        }
        array_push($path, 0);

        $this->path = $path;
    }

    public function __toString()
    {
        $ret = "Itinéraire : ";
        foreach($this->path as $point) {
            $ret .= "$point -> ";
        }
        $ret .= "Total : {$this->getDistanceTrajet()}m";
        return $ret;
    }
}