<?php
require_once __DIR__ . '/Repository/DepartmentRepository.php';
require_once __DIR__ . '/database/Connextion.php';
require_once __DIR__ . '/Service/login.php';
require_once __DIR__ . '/Repository/CourseRepository.php';




$connexion = new Connextion();

$pdo = $connexion->getConnextion();

$departmentRepository = new DepartmentRepository($pdo);
$loginService = new LoginService($pdo);
$coursRepository = new CourseRepository($pdo);


do {
    do {
        echo "===** LOGIN **===\n";
        echo "Entrer votre Email : ";
        $email = trim(fgets(STDIN));
        echo "Entrer votre password : ";
        $password = trim(fgets(STDIN));
        $array = $loginService->checkData($email);
        $element = $array[0];
        if (empty($element)) {
            echo "!!!!! verifier votre email est incorrect   !!!!!\n";
        }
    } while (empty($element));
    if ($password !== $element['password']) {
        echo "!!!!!    votre password est  incorrect  !!!!\n";
    }
    echo "\n";
} while ($password !== $element['password']);



while (true) {
    if ($element["role"] === "ADMIN") {
        echo "---------------------------------------";
        echo "\n     ==** gestion des universités **==\n";
        echo "     1- gestion des departements.\n";
        echo "     2- gestion des etudiants.\n";
        echo "     3- gestion des formateurs\n";
        echo "     4- gestion des cours\n";
        echo "     5- Quitter\n";


        $choix = trim(fgets(STDIN));
    } else {
        echo "    ==** gestion des universités **==\n";
        echo "    1- consolter votre cours.\n";
        echo "    2- voire votre infos.\n";
        echo "    3- voire votre  formateur\n";
        echo "    4- voire votre  departement\n";

        $etudChoix = trim(fgets(STDIN));
    }
    switch ($choix) {
        case 1:
           Departement($departmentRepository);
            break;

        case 2:
           Etudiant();
            break;
        case 3:
           Formateur();
            break;
        case 4:
           Coures($coursRepository,$departmentRepository);
            break;
        case 5:
            exit;
        default:
            echo "Aucun choix valide\n";
            break;
    }
}
function Departement($departmentRepository){
     while (true) {
                echo "---------------------------------------";
                echo "\n   === Gestion des départements ===\n";
                echo "\n1- ajouter un deparetement.\n";
                echo "2- supprimer un deparetement.\n";
                echo "3- modifier un  deparetement\n";
                echo "4- quitter\n";
                $D = trim(fgets(STDIN));

                switch ($D) {

                    case 1:
                        echo "** Ajouter un département : **\n";
                        echo "\nNom du département : ";
                        $nameDepartment = trim(fgets(STDIN));

                        $department = new Department($nameDepartment);

                        $departmentRepository->addDepartment($department);

                        echo "Departement ajoute par succes\n\n";
                        break;
                    case 2:
                        echo "** suppimer un département : **\n";
                        $departmentArray = $departmentRepository->salactALLDep();
                        foreach ($departmentArray as $dept) {
                            echo $dept['id'] . " - " . $dept['name'];
                            echo "\n";
                        }
                        echo "\n Saisir Id du département va supprimer : ";
                        $departmentID = trim(fgets(STDIN));
                        $departmentRepository->deleteDepartment($departmentID);
                        echo "Departement supprimer par succes\n";
                        break;
                    case 3:
                        echo "** Modifer un département : **\n";
                        $departmentArray = $departmentRepository->salactALLDep();
                        foreach ($departmentArray as $dept) {
                            echo $dept['id'] . " - " . $dept['name'];
                            echo "\n";
                        }
                        echo "\n Saisir Id du département : ";
                        $DepartmentID = trim(fgets(STDIN));
                        echo "Entrer nouvelle nom du département : ";
                        $nameDepartment = trim(fgets(STDIN));

                        $departmentRepository->updateDepartment($nameDepartment, $DepartmentID);

                        echo "Departement modifier par succes\n";
                        break;
                    case 4:
                       return;
                    default:
                        echo "\n !!! aucune choix !!!!\n";
                }
            }
}
function Coures($coursRepository,$departmentRepository){
 while(true){
                echo "---------------------------------------";

                echo "\n      === Gestion des cours   ===\n";
                echo "1- ajouter un cours.\n";
                echo "2- supprimer un cours.\n";
                echo "3- modifier un  cours\n";
                echo "4- quitter\n";
                $C = trim(fgets(STDIN));
            switch ($C) {

                case 1:
                    echo "\nAjouter un cours :\n";
                    echo "\n  saisir tittre de coures : ";
                    $titre = trim(fgets(STDIN));
                    echo "\n  la listes des departement : \n";

                    $departmentArray = $departmentRepository->salactALLDep();
                    foreach ($departmentArray as $dept) {
                        echo $dept['id'] . " - " . $dept['name'];
                        echo "\n";
                    }
                    echo "\nChoisir Id de Departement de se cours : ";
                    $Iddepartement = trim(fgets(STDIN));
                    $coure = new Course($titre, $Iddepartement);
                    $coursRepository->AddCours($coure);
                    echo "\ncours ajoute par succes\n";
                    break;
                case 2:
                    echo "\nSupprimer un cours :\n";
                    echo "\n ** Choisir ID de cours va supprimer :\n";

                    $coursArray = $coursRepository->selectAllCoures();
                    foreach ($coursArray as $coure) {
                        echo $coure['id'] . " <=> Titre de cours :\"" . $coure['titre'] . "\" <=> Id de Departement :[ " . $coure['department_id'] . "]";
                        echo "\n";
                    }
                    echo "====>>";
                    $idcours = trim(fgets(STDIN));
                    $coursRepository->deleteCourse($idcours);

                    echo "Coures etait supprimer par succes\n";
                    break;
                case 3:
                    echo "\Modifier un cours :\n";
                    echo "\n ** Choisir ID de cours va modifier :\n";

                    $coursArray = $coursRepository->selectAllCoures();
                    foreach ($coursArray as $coure) {
                        echo ": " . $coure['id'] . "- Titre de cours :\" " . $coure['titre'] . " \" => Id de Departement :[ " . $coure['department_id'] . " ]";
                        echo "\n";
                    }
                    echo "====>>";
                    $idcoursmdfier = trim(fgets(STDIN));
                    echo "Entrer nouvelle titre de cours :\n";
                    $titremdfier = trim(fgets(STDIN));
                    echo  "Saisir new ID de departement de cours :\n";
                    $idDepmdfier = trim(fgets(STDIN));

                    $coursRepository->updateCours($titremdfier, $idDepmdfier, $idcoursmdfier);

                    echo "Coures etait supprimer par succes\n";
                    break;
                case 4:
                    break;
                default:
                    echo "\naucune choix\n";
            }
        }
}
function Etudiant(){
 while(true){
                echo "---------------------------------------";
                echo "\n     === Gestion des étudiants   ===\n";
                echo "1- ajouter un etudiant.\n";
                echo "2- supprimer un etudiant.\n";
                echo "3- modifier un  etudiant\n";
                echo "4- quitter\n";
                $E = trim(fgets(STDIN));
            switch ($E) {

                case 1:
                    echo "Ajouter etudiant :";
                    echo "Firstname d'étudiant : ";
                    $etudFirstname = trim(fgets(STDIN));
                    echo "Lastname d'étudiant : ";
                    $etudLastname = trim(fgets(STDIN));
                    break;
                    echo "etudiant ajoute par succes\n";
                    break;
                case 2:

                    break;
                case 3:

                    break;
                case 4:

                    break;
                default:
                    echo "\naucune choix\n";
            }
        }
}
function Formateur(){
     while(true){
                echo "---------------------------------------";

                echo "\n      === Gestion des formateurs   ===\n";
                echo "1- ajouter un formateur.\n";
                echo "2- supprimer un formateur.\n";
                echo "3- modifier un  formateur\n";
                echo "4- quitter\n";
                $F = trim(fgets(STDIN));
            switch ($F) {

                case 1:
                    echo "Ajouter formateur :";
                    echo "Firstname de formateur : ";
                    $formatFirstname = trim(fgets(STDIN));
                    echo "Lastname de formateur : ";
                    $formatFirstname = trim(fgets(STDIN));
                    break;
                    echo "formateur ajoute par succes\n";
                    break;
                case 2:

                    break;
                case 3:

                    break;
                case 4:

                    break;
                default:
                    echo "\naucune choix\n";
            }
        }
}