<?php


class Course
{
    private int $id;
    private string $titre;
    private int $departmentId;
    private int $formateurId;

    public function __construct(string $titre, int $departmentId, int $id,$formateurId)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->departmentId = $departmentId;
        $this->formateurId=$formateurId;
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
    public function getFormateurId()
    {
        return $this->formateurId;
    }
    public function settitre(string $titre)
    {
        $this->titre = $titre;
    }

    public function setDepartmentId(int $departmentId)
    {
        $this->departmentId = $departmentId;
    }
     public function setFormateurId(int $formateurId)
    {
        $this->formateurId = $formateurId;
    }
}
