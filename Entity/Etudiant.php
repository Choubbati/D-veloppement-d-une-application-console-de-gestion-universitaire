<?php 
    class Etudiant extends Personne{

    private string $niveau;
     public function __construct(int $id, string $firstname, string $lastname, string $email, string $password,string $niveau){
        return parent::__construct($id, $firstname, $lastname, $email, $password,Role::ETUDIANT);
        $this->nivceau = $niveau;
     }

     public function getNiveau() : string{
        return $this->niveau;
     }

     public function setNiveau($niveau):void{
        $this->niveau=$niveau;
     }

    


    }

?>