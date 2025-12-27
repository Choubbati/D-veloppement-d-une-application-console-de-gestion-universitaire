<?php
require_once __DIR__ . '/Entity/Department.php';
require_once __DIR__ . '/Repository/DepartmentRepository.php';
require_once __DIR__ . '/database/Connextion.php';


$connexion = new Connextion();

$pdo = $connexion->getConnextion();

$departmentRepository = new DepartmentRepository($pdo);

do {
    echo "===** LOGIN **===\n";
    echo "Entrer votre Email : ";
    $email = trim(fgets(STDIN));
    echo "Entrer votre password : ";
    $password = trim(fgets(STDIN));
    if ($email != "mohamedel@gmail.com" && $password != "azert54321") {
        echo "*****!!!!!! invalide try again !!!!!*****\n";
    }
} while ($email !== "mohamedel@gmail.com" && $password !== "azert54321");

echo "==** gestion des universités **==\n";
echo "1- gestion des departements.\n";
echo "2- gestion des etudiants.\n";
echo "3- gestion des formateurs\n";
$choix = trim(fgets(STDIN));

switch ($choix) {
    case 1:
        echo "=== Création d'un département ===\n";
        echo "Nom du département : ";
        $nameDepartment = trim(fgets(STDIN));
        
        $department = new Department($nameDepartment);

        $departmentRepository->addDepartment($department);           

        echo "Departement ajoute par succes\n";
        break;

    case 2:
        // echo "=== Création d'un étudiant ===\n";
        // echo "Firstname d'étudiant : ";
        // $etudFirstname = trim(fgets(STDIN));
        // echo "Lastname d'étudiant : ";
        // $etudLastname = trim(fgets(STDIN));
        // break;

    case 3:
        // echo "=== Création d'un formateur ===\n";
        // echo "Firstname du formateur : ";
        // $formatFirstname = trim(fgets(STDIN));
        // echo "Lastname du formateur : ";
        // $formatLastname = trim(fgets(STDIN));
        // break;

    default:
        echo "Aucun choix valide\n";
        break;
}

// echo "=== Création d'un formateur ===\n";
//         echo "Firstname du formateur : ";
//         $formatFirstname = trim(fgets(STDIN));
//         echo "Lastname du formateur : ";
//         $formatLastname = trim(fgets(STDIN));
