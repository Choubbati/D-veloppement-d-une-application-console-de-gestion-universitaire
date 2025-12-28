<?php

class Department
{
    private ?int $id;
    private string $name;


    public function __construct(string $name,?int $id=null)
    {
         $this->name = $name;
         $this->id = $id;
       
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
