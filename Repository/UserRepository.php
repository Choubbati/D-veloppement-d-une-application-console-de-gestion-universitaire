<?php
class User_Repository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(string $email, string $password): ?array
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return null;
        }
    }

    public function add(string $firstname, string $lastname, string $email, string $password, string $role): bool
    {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role) 
                VALUES (:firstname, :lastname, :email, :password, :role)";

        $stmt = $this->pdo->prepare($sql);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':firstname' => $firstname,
            ':lastname'  => $lastname,
            ':email'     => $email,
            ':password'  => $hashedPassword,
            ':role'      => $role
        ]);
    }

    public function update(int $id, string $firstname, string $lastname, string $email, string $password, string $role): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, password=:password, role=:role WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':firstname' => $firstname,
            ':lastname'  => $lastname,
            ':email'     => $email,
            ':password'  => $hashedPassword,
            ':role'      => $role,
            ':id'        => $id
        ]);
    }



    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function selectAll(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCouresByDepartment(int $id): array
    {
        $sql = "
        SELECT 
            C.*
        FROM courses c
        JOIN departments d ON d.id = c.department
        WHERE d.id= ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCouresByFormateur(int $ID): array
    {
        $sql = "
        SELECT 
           c.*,
           firstname,
           lastname
        FROM formateur_course fc
        JOIN courses c ON c.id = fc.course_id
        JOIN formateur f ON f.id = fc.formateur_id
        JOIN users u ON u.id=f.id
        WHERE f.id = ? ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectEtudiantByDepartment(int $ID): array
    {
        $sql = "
        SELECT 
           u.*,
           e.*
        FROM etudiant_course ec
        JOIN etudiants e ON e.id = ec.etudiant_id
        JOIN courses c ON c.id = ec.course_id
        JOIN departments d ON d.id = c.department
        JOIN users u ON u.id=e.id
        WHERE d.id = ? ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
