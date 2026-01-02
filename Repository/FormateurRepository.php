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

    public function Add(Formateur $f): bool
    {

        $sql = "INSERT INTO formateurs (firstname, lastname, email, password, role, specialite)
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$f->getFirstName(), $f->getLastName(), $f->getEmail(), $f->getPassword(), $f->getRole()->value, $f->getSpecialite()]);
    }


    public function delete(int $id): bool
    {

        $sql = "DELETE FROM formateurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function update(int $id, Formateur $formateur): bool
    {

        $sql = "UPDATE formateurs SET firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    specialite = :specialite
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'firstname'  => $formateur->getFirstname(),
            'lastname'   => $formateur->getLastname(),
            'email'      => $formateur->getEmail(),
            'specialite' => $formateur->getSpecialite(),
            'id'         => $id
        ]);
    }
    public function selectAll(): array
    {
        $sql = "SELECT * FROM formateurs ";
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
