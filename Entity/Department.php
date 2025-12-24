<?php

class Department
{
    private string $firstname;
    private string $lastname;

    public function __construct(string $firstname, string $lastname)
    {
        // $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
    function getFirstname()
    {
        return $this->firstname;
    }
    function getLastname()
    {
        return $this->lastname;
    }
    function setFirstname(string $firstname)
    {
        return $this->firstname = $firstname;
    }
    function setLastname(string $lastname)
    {
        return $this->firstname = $lastname;
    }
    // function setId(int $id)
    // {
    //     return $this->id = $id;
    // }
    // function getId()
    // {
    //     return $this->id;
    // }
}
