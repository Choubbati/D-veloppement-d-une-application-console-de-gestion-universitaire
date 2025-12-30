<?php
class Etudiant extends Personne
{

   private string $niveau;
   private string $cne;

   public function __construct(string $firstname, string $lastname, string $email, string $password, Role $role, string $niveau, string $cne, ?int $id = null)
   {
      parent::__construct($firstname, $lastname, $email, $password, $role, $id);
      $this->niveau = $niveau;
      $this->cne = $cne;
   }
   public function getNiveau(): string
   {
      return $this->niveau;
   }

   public function setNiveau($niveau): void
   {
      $this->niveau = $niveau;
   }
   public function getCNE(): string
   {
      return $this->cne;
   }

   public function setCNE($cne): void
   {
      $this->cne = $cne;
   }
}
