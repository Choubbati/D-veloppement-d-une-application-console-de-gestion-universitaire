<?php 
require_once __DIR__ . '/../Entity/Department.php';

require_once __DIR__ . '/../database/Connextion.php';

class DepartmentRepository{

    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addDepartment(Department $department)
    {
        $sql = "INSERT INTO departments ( name) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$department->getname()]);
    }


}