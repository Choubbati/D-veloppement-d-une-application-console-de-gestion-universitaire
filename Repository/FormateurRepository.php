<?php

require_once __DIR__ . '/../Entity/Formateur.php';
require_once __DIR__ . '/../database/Connextion.php';
require_once __DIR__ . '/../Abstract/Person.php';

class FormateurRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Formateur $f): bool
    {
        $sqlF = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (:fn, :ln, :email, :pwd, :role)";
        $stmt = $this->pdo->prepare($sqlF);

        $hashedPassword = password_hash($f->getPassword(), PASSWORD_DEFAULT);

        $stmt->execute([
            'fn'     => $f->getFirstName(),
            'ln'     => $f->getLastName(),
            'email'  => $f->getEmail(),
            'pwd'    => $hashedPassword,
            'role'   => $f->getRole()->value
        ]);
        $lastID=$this->pdo->lastInsertId();
        $sql = "INSERT INTO formateur (id, specialite) VALUES (?, ?)";
        $stmtF = $this->pdo->prepare($sql);
       return $stmtF->execute([$lastID, $f->getSpecialite()]);
        
    }

    public function delete(int $id): bool
    {

        $sqlF = "DELETE FROM formateur WHERE id = ?";
        $stmt = $this->pdo->prepare($sqlF);
        $stmt->execute([$id]);
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(int $id, Formateur $formateur): bool
    {

        $sql = "UPDATE users SET 
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    password  =  :pwd
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $hashedPassword = password_hash($formateur->getPassword(), PASSWORD_DEFAULT);

        $stmt->execute([
            'firstname'  => $formateur->getFirstname(),
            'lastname'   => $formateur->getLastname(),
            'email'      => $formateur->getEmail(),
            'pwd'         => $hashedPassword,
            'id'     => $id

        ]);
         $sqlF = "UPDATE formateur SET 
                   specialite = :specialite
                   WHERE id = :id";
        $stmtF=$this->pdo->prepare($sqlF);
        return $stmtF->execute(['id'=>$id,'specialite'=>$formateur->getSpecialite()]);

    }

    public function selectAll(): array
    {
        $sql = "SELECT  
            firstname ,
            lastname,
            email,
            f.* 
         FROM users u 
        INNER JOIN formateur f ON u.id=f.id ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectById($id): ?Formateur
    {
        $sql = "SELECT * FROM formateurs WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }else{
            return new Formateur($row['$firstname'],$row['$lastname'],$row['$email'],$row['$password'],$row['$role'],$row['$specialite'],$row['$id']);
        }
    }
}
