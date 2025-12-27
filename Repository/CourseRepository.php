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

    public function ajouter(Course $course): bool
    {
        $sql = "INSERT INTO courses (titre, department_id, formateur_id)VALUES(:titre, :departmentId, :formateurId)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $course->gettitre(),
            ':departmentId' => $course->getDepartmentId(),
            ':formateurId' => $course->getFormateurId()
        ]);
    }

    public function modifier(Course $course): bool
    {
        $sql = "UPDATE cours 
                SET titre = :titre,
                    department_id = :departmentId,
                    formateur_id = :formateurId
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $course->gettitre(),
            ':departmentId' => $course->getDepartmentId(),
            ':formateurId' => $course->getFormateurId(),
            ':id' => $course->getId()
        ]);
    }

    public function supprimer(int $id): bool
    {
        $sql = "DELETE FROM cours WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }


    public function selectAll(): array
    {
        $sql = "SELECT * FROM cours";
        $stmt = $this->pdo->query($sql);

        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $row['titre'],
                $row['department_id'],
                $row['id'],
                $row['formateur_id']
            );
        }

        return $courses;
    }
}
