<?php

require_once __DIR__ . '/../Entity/Etudiant.php';
require_once __DIR__ . '/../database/Connextion.php';

class EtudiantRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function Add(Etudiant $etd): bool
    {

        $sql = "INSERT INTO etudiants (firstname, lastname, email, password, role, niveau, CNE)
                VALUES (:fn, :ln, :email, :pwd, :role, :niveau ,:cne )";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'fn'     => $etd->getFirstname(),
            'ln'     => $etd->getLastname(),
            'email'  => $etd->getEmail(),
            'pwd'    => $etd->getPassword(),
            'role'   => $etd->getRole()->value,
            'niveau' => $etd->getNiveau(),
            'cne' => $etd->getCNE()
        ]);
        return (int) $this->pdo->lastInsertId();
    }
    public function update(int $id, Etudiant $etd): bool
    {

        $sql = "UPDATE etudiants SET
                    firstname = :fn,
                    lastname = :ln,
                    email = :email,
                    niveau = :niveau,
                    CNE = :cne
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'fn'   => $etd->getFirstname(),
            'ln'  => $etd->getLastname(),
            'email' => $etd->getEmail(),
            'niveau' => $etd->getNiveau(),
            'cne' => $etd->getCNE(),
            'id'     => $id
        ]);
    }

    public function delete(int $id): bool
    {

        $sql = "DELETE FROM etudiants WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
    public function selectAll(): array
    {

        $sql = "SELECT * FROM etudiants";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
