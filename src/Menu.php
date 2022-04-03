<?php

declare(strict_types=1);

class Menu
{
    private $id;
    private $nom;
    private $prix;
    private $reduc;
    private $desc;
    private $url;

    public function __construct(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Menu
                WHERE idMenu = $id
SQL);
        $stmt->execute();

        $req = $stmt->fetchAll();

        $this->id = (int) $req[0]['idMenu'] ?? '';
        $this->nom = $req[0]['nomMenu'] ?? '';
        $this->prix = $req[0]['prixMenu'] ?? '';
        $this->reduc = $req[0]['reduction'] ?? '';
        $this->desc = $req[0]['descMenu'] ?? '';
        $this->url = $req[0]['ulrImgMenu'] ?? '';
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

    public function getReduc(): string
    {
        return $this->reduc;
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
                SELECT idMenu
                FROM Menu
SQL);
        $stmt->execute();

        return count($stmt->fetchAll());
    }

    public static function getAllId(): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT idMenu
                FROM Menu
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
