<?php
require_once __DIR__ . '/../Entity/Department.php';

require_once __DIR__ . '/../database/Connextion.php';

class DepartmentRepository
{

    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function salactALLDep():array{
        $sql="SELECT * From departments ";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDepartment(Department $department):bool
    {
        $sql = "INSERT INTO departments (name) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$department->getname()]);
    }

    public function updateDepartment(string $newName, int $id): bool
    {
        $sql = "UPDATE departments SET name = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$newName, $id]);
    }


    public function deleteDepartment(int $id): bool
    {
        $sql = "DELETE FROM departments WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}
