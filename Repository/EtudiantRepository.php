<?php

require_once __DIR__ . '/../Entity/Etudiant.php';
require_once __DIR__ . '/../database/Connextion.php';
require_once __DIR__ . '/UserRepository.php';

class EtudiantRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Etudiant $etd): int
    {
         
        $sqlP = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (:fn, :ln, :email, :pwd, :role)";
        $stmt = $this->pdo->prepare($sqlP);

        $hashedPassword = password_hash($etd->getPassword(), PASSWORD_DEFAULT);

        $stmt->execute([
            'fn'     => $etd->getFirstName(),
            'ln'     => $etd->getLastName(),
            'email'  => $etd->getEmail(),
            'pwd'    => $hashedPassword,
            'role'   => $etd->getRole()->value
        ]);
        $lastID=$this->pdo->lastInsertId();
        
        $sqlE = "INSERT INTO etudiants (id, niveau, CNE) VALUES (:id, :niveau ,:cne )";
        $stmtE = $this->pdo->prepare($sqlE);
        $stmtE->execute(['id' => $lastID,'niveau' => $etd->getNiveau(),'cne' => $etd->getCNE()]);
        
        return $lastID;
    }

    public function update(int $id, Etudiant $etd): bool
    {

        $sqlP = "UPDATE users SET
                    firstname = :fn,
                    lastname = :ln,
                    email = :email,
                    password = :pwd
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sqlP);

        $hashedPassword = password_hash($etd->getPassword(), PASSWORD_DEFAULT);

        $stmt->execute([
            'fn'     => $etd->getFirstname(),
            'ln'     => $etd->getLastname(),
            'email'  => $etd->getEmail(),
            'pwd'    => $hashedPassword,
            'id'     => $id
        ]);
        $sqlE = "UPDATE etudiants SET 
        niveau = :niveau,
        CNE = :cne 
        WHERE id = :id ";
        $stmtE = $this->pdo->prepare($sqlE);
        return $stmtE->execute(['id' => $id,'niveau' => $etd->getNiveau(),'cne' => $etd->getCNE()]);
    }

    public function delete(int $id): bool
    {

        $sqlfk = "DELETE FROM etudiants WHERE id = :id";
        $stmt = $this->pdo->prepare($sqlfk);
        $stmt->execute(['id' => $id]); 
        
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
    public function selectAll(): array
    {

        $sql = "SELECT
            firstname ,
            lastname,
            email,
            e.* 
        FROM users u INNER JOIN etudiants e ON u.id=e.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
