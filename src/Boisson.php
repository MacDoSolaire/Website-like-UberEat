<?php

declare(strict_types=1);

class Boisson
{
    private $id;
    private $nom;
    private $prix;
    private $taille;
    private $desc;
    private $url;

    public function __construct(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Boisson
                WHERE idBoisson = $id
SQL);
        $stmt->execute();

        $req = $stmt->fetchAll();

        $this->id = (int) $req[0]['idBoisson'] ?? '';
        $this->nom = $req[0]['nomBoisson'] ?? '';
        $this->prix = $req[0]['prixBoisson'] ?? '';
        $this->taille = (int) $req[0]['qteBoisson'] ?? '';
        $this->desc = $req[0]['descBoisson'] ?? '';
        $this->url = $req[0]['ulrImgBoisson'] ?? '';
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

    public function getTaille(): string
    {
        return $this->taille;
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
                SELECT idBoisson
                FROM Boisson
SQL);
        $stmt->execute();

        return count($stmt->fetchAll());
    }

    public static function getAllId(): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT idBoisson
                FROM Boisson
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
