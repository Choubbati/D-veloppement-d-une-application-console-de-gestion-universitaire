<?php
require 'Entity\Department.php';
require 'Repository\DepartmentRepository.php';


do{
echo "===** LOGIN **===\n";
echo "Entrer votre Email :";
$email = trim(fgets(STDIN));
echo "Entrer votre password :";
$password = trim(fgets(STDIN));
if ($email != "mohamedel@gmail.com" && $password != "azert54321") {
  echo "*****!!!!!! invalide try againe !!!!!*****\n";
}
}while($email != "mohamedel@gmail.com" && $password != "azert54321");

    echo "==** getsion des univercity **==\n";
    echo "1- getion des deparetement.\n";
    echo "2- gestion des etudiant.\n";
    echo "3- gestion des formateur\n";
    $choix = fgets(STDIN);
    switch ($choix) {
        case 1:
            echo "=== Création d'un département ===\n";
            echo "Firstname du département : ";
            $depFirstname = trim(fgets(STDIN));
            echo "Lastname du département : ";
            $depLastname = trim(fgets(STDIN));
            break;
        case 2:
            echo "=== Création d'un etudiant ===\n";
            echo "Firstname d'etudiant : ";
            $etudFirstname = trim(fgets(STDIN));
            echo "Lastname d'etudiant : ";
            $etudLastname = trim(fgets(STDIN));
            break;
        case 3;
            echo "=== Création d'un formateur ===\n";
            echo "Firstname du formateur : ";
            $formatFirstname = trim(fgets(STDIN));
            echo "Lastname du formateur : ";
            $formatLastname = trim(fgets(STDIN));
            break;
        default:
        echo "aucune choix";

    }





// $department = new Department($depFirstname,$depLastname);
// var_dump($department);
// $departmentRepository = new DepartmentRepository();
