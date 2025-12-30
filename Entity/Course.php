<?php


class Course
{
    private ?int $id;
    private string $titre;
    private int $departmentId;

    public function __construct(string $titre, int $departmentId,?int $id=null)
    {
        $this->titre = $titre;
        $this->departmentId = $departmentId;
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
    public function getDepartmentId()
    {
        return $this->departmentId;
    }
   
    public function settitre(string $titre)
    {
        $this->titre = $titre;
    }

    public function setDepartmentId(int $departmentId)
    {
        $this->departmentId = $departmentId;
    }
     
}
