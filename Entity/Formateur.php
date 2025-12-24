<?php 

    require __DIR__ . '/../Abstract/Person.php';

    class Formateur extends Personne{

        private string $specialiste;

        public function __construct(int $id, string $firstname, string $lastname, string $email, string $phone)
        {
            return parent::__construct($id, $firstname, $lastname, $email, $phone);
            $this->specialiste = $specialiste;
        }

        public function getRole(): string
        {
            return 'Formateur';
        }

    }


    
?> 




