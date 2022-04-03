<?php

declare(strict_types=1);

class CodePromo
{
    private $idCode;
    private $nomCode;
    private $montant;

    public function __construct(int $idCode)
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM CodePromo
                WHERE id = $idCode
SQL);
        $stmt->execute();

        $req = $stmt->fetchAll();

        $this->idCode = (int) $req[0]['idCode'] ?? '';
        $this->nomCode = $req[0]['nomCode'] ?? '';
        $this->montant = $req[0]['montant'] ?? '';
        
        
        
    }

    public function getId(): int
    {
        return $this->idCode;
    }

    public function getName(): string
    {
        return $this->nomCode;
    }

    public function getMontant(): float 
    {
        return $this->montant;
    }
}
