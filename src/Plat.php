<?php

declare(strict_types=1);

class Plat
{
    private $id;
    private $nom;
    private $prix;
    private $desc;
    private $url;

    public function __construct(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Plat
                WHERE idPlat = $id
SQL);
        $stmt->execute();

        $req = $stmt->fetchAll();

        $this->id = (int) $req[0]['idPlat'] ?? '';
        $this->nom = $req[0]['nomPlat'] ?? '';
        $this->prix = $req[0]['prixPlat'] ?? '';
        $this->desc = $req[0]['descPlat'] ?? '';
        $this->url = $req[0]['ulrImgPlat'] ?? '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return utf8_encode($this->nom);
    }

    public function getPrice(): string
    {
        return $this->prix;
    }

    public function getDesc(): string
    {
        return utf8_encode($this->desc);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public static function getNb(): int
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT idPlat
                FROM Plat
SQL);
        $stmt->execute();

        return count($stmt->fetchAll());
    }

    public static function getAllId(): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT idPlat
                FROM Plat
SQL);
        $stmt->execute();
        $req = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $arrayId = array();

        foreach ($req as $elmt) {
            array_push($arrayId, $elmt);
        }

        return $arrayId;
    }
}
