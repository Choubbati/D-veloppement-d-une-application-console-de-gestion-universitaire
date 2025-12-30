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
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEtudiantsByDepartment(): array
    {
        $sql = "
        SELECT 
            d.name AS department,
            e.firstname AS firstname,
            e.lastname AS lastnale,
            e.CNE AS CNE
        FROM departments d
        JOIN courses c ON c.department_id = d.id
        JOIN etudiant_course ec ON ec.course_id = c.id
        JOIN etudiants e ON e.id = ec.etudiant_id
        ORDER BY d.name, e.lastname
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCoursesByEtudiant(int $etudiantId): array
    {
        $sql = "
        SELECT 
            c.titre AS course,
            d.name AS department
        FROM etudiant_course ec
        JOIN courses c ON c.id = ec.course_id
        JOIN departments d ON d.id = c.department_id
        WHERE ec.etudiant_id = :id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $etudiantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
