<?php 
 

 class Etudiant_Course {

       private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function add(int $IdEtt , int $IdCrs):bool
    {
      $sql="INSERT INTO etudiant_course (etudiant_id ,course_id)VALUES(?,?)";
      $stmt=$this->pdo->prepare($sql);
      return $stmt->execute([$IdEtt,$IdCrs]);
    }

 }