<?php
abstract class Personne
{
    protected int $id;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $phone;

    public function __construct(int $id,string $firstname,string $lastname,string $email,string $phone)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getId():int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id=$id;
    } 

        public function getFirstName():string{
        return $this->firstname;
    }
    public function setFirstName(string $firstname):void{
        $this->firstname=$firstname;
    } 

    public function getLastName():string{
        return $this->lastname;
    }
    public function setLastName(string $lastname):void{
        $this->lastname=$lastname;
    } 


    public function getEmail():string{
        return $this->email;
        
    }

    public function setEmail( string $email):void{
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            throw new Exception("Email invalide");
            
        }
        $this->email=$email;
    }

    public function getPhone():string{
        return $this->phone;
    }

    public function setPhone(string $phone):void{
        $this->phone=$phone;
    }

    
}