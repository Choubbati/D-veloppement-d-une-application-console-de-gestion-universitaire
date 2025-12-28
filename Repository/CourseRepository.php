<?php

require_once __DIR__ . '/../database/connextion.php';
require_once __DIR__ . '/../Entity/Course.php';

class CourseRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function AddCours(Course $course): bool
    {
        $sql = "INSERT INTO courses (titre, department_id)VALUES(?,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$course->gettitre(),$course->getDepartmentId()]);
    }

    public function updateCours(string $titre,int $id_department,int $id): bool
    {
        $sql = "UPDATE courses  SET titre = ? , department_id = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$titre,$id_department,$id]);
    }

    public function deleteCourse(int $id): bool
    {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


    public function selectAllCoures(): array
    {
        $sql = "SELECT * FROM courses";
        $stmt = $this->pdo->query($sql);
        $stmt->execute();
        $courses=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courses;
    }
}
