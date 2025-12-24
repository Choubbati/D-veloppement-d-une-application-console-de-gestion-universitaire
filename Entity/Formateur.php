<?php 

    require __DIR__ . '/../Abstract/Person.php';

    class Formateur extends Personne{

        private string $specialiste;

        public function __construct(int $id, string $firstname, string $lastname, string $email, string $password, string $specialiste){
            return parent::__construct($id, $firstname, $lastname, $email, $password,Role::FORMATEUR);
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




