<?php 
 

 class Formateur_Coures {

       private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function add(int $IdFormt , int $IdCrs):bool
    {
      $sql="INSERT INTO formateur_course (formateur_id ,course_id)VALUES(?,?)";
      $stmt=$this->pdo->prepare($sql);
      return $stmt->execute([$IdFormt,$IdCrs]);
    }

 }