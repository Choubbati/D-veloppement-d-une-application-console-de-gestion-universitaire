<?php

require_once __DIR__ . '/../database/connextion.php';
require_once __DIR__ . '/../Entity/Course.php';

class CourseRepository implements CrudInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function Add(Course $course): int
    {
        $sql = "INSERT INTO courses (titre, department_id)VALUES(?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course->gettitre(),$course->getDepartmentId()]);
        return (int) $this->pdo->lastInsertId();
        
    }

    public function update(int $id,Course $coure): bool
    {
        $sql = "UPDATE courses  SET titre = ? , department_id = ?  WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$coure->gettitre(),$coure->getDepartmentId(),$id]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


    public function selectAll(): array
    {
        $sql = "SELECT * FROM courses";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courses;
    }
    
}
