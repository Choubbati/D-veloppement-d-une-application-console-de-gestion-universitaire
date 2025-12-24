<?php 
    class Etudiant extends Personne{

        private string $niveau;
     public function __construct(int $id, string $firstname, string $lastname, string $email, string $phone)
     {
        return parent::__construct($id, $firstname, $lastname, $email, $phone);
        $this->nivceau = $niveau;
     }



    public function getRole(): string
    {
        return "Etudiant";
    }


    }

?>