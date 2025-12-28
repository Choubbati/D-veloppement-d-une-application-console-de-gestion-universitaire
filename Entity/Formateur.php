<?php 

    require __DIR__ . '/../Abstract/Person.php';

    class Formateur extends Personne{

        private string $specialiste;

        public function __construct( string $firstname, string $lastname, string $email, string $password, Role $role, string $specialiste, ?int $id=null){
            parent::__construct($firstname, $lastname, $email, $password,$role,$id);
            $this->specialiste = $specialiste;
        }

        public function getSpecialite(): string{
            return $this->specialiste;
        } 

        public function setSpecialite(string $specialiste): void{
            $this->specialiste = $specialiste;
        }

    }


    
?> 




