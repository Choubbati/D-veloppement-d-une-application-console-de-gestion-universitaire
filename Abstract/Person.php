<?php


abstract class Personne
{
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected Role $role;
    protected ?int $id;

    public function __construct(string $firstname,string $lastname,string $email,string $password,Role $role, ?int $id=null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role=$role;
        $this->id = $id;
        
      
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
    public function getRole(): Role
        {
            return $this->role;
        }
        
        function getPassword():string{
            return $this->password;
        }

        function setPassword($password):void{
            $this->password = $password;
        }

}