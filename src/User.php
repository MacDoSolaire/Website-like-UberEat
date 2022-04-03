<?php

declare(strict_types=1);

class User
{
    private $id;
    private $role;
    private $nom;
    private $prenom;
    private $login;
    private $mail;
    private $tel;
    private $adresse;
    private $ville;
    private $codePost;

    public function __construct(int $id)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM client
                WHERE idCli = $id
SQL);
        $stmt->execute();

        $req = $stmt->fetchAll();

        $this->id = (int) $req[0]['idCli'] ?? '';
        $this->role = $req[0]['roleCli'] ?? '';
        $this->nom = $req[0]['nomCli'] ?? '';
        $this->prenom = $req[0]['prnCli'] ?? '';
        $this->login = $req[0]['login'] ?? '';
        $this->mail = $req[0]['mailCli'] ?? '';
        $this->tel = $req[0]['telCli'] ?? '';
        $this->adresse = $req[0]['adrCli'] ?? '';
        $this->ville = $req[0]['ville'] ?? '';
        $this->codePost = $req[0]['cdPost'] ?? '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getLastName(): string
    {
        return utf8_encode($this->nom);
    }

    public function getFirstName(): string
    {
        return utf8_encode($this->prenom);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function getAdr(): string
    {
        return utf8_encode($this->adresse);
    }

    public function getCity(): string
    {
        return utf8_encode($this->ville);
    }

    public function getCdPost(): string
    {
        return $this->codePost;
    }

    public function addFull() : string{
        return utf8_encode($this->adresse . ', ' . $this->codePost . ' ' . $this->ville);
    }
}
