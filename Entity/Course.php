<?php
require_once __DIR__ . '/Department.php';

class Course
{
    private ?int $id;
    private string $titre;
    private Department $department;

    public function __construct(string $titre, Department $department,?int $id=null)
    {
        $this->titre = $titre;
        $this->department = $department;
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function gettitre()
    {
        return $this->titre;
    }
    public function getDepartment()
    {
        return $this->department;
    }
   
    public function settitre(string $titre)
    {
        $this->titre = $titre;
    }

    public function setDepartmentId(Department $department)
    {
        $this->department = $department;
    }
     
}
