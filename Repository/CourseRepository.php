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

    public function Add(Course $course): int
    {
        $sql = "INSERT INTO courses (titre, department)VALUES(?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course->gettitre(), $course->getDepartment()->getId()]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, Course $coure): bool
    {
        $sql = "UPDATE courses  SET titre = ? , department = ?  WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$coure->gettitre(), $coure->getDepartment()->getId(), $id]);
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
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courses;
    }
    public function selectAllInfos(): array
    {
        $sql = "
        SELECT * 
        FROM courses c
        INNER JOIN formateur_course fc ON c.id = fc.course_id
        INNER JOIN formateur f ON fc.formateur_id = f.id 
        INNER JOIN users u ON u.id=f.id
        INNER JOIN departments d ON d.id=c.department";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courses;
    }
}
