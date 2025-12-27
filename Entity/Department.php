<?php

class Department
{
    private ?int $id;
    private string $name;


    public function __construct(?int $id=null,string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    function getname()
    {
        return $this->name;
    }
   
    function setname(string $name)
    {
        return $this->name = $name;
    }
   
    function setId(int $id)
    {
        return $this->id = $id;
    }
    function getId()
    {
        return $this->id;
    }
}
