<?php
require_once __DIR__ . '/Repository/DepartmentRepository.php';
require_once __DIR__ . '/database/Connextion.php';
require_once __DIR__ . '/Service/login.php';
require_once __DIR__ . '/Repository/CourseRepository.php';
require_once __DIR__ . '/Repository/FormateurRepository.php';
require_once __DIR__ . '/Enum/Role.php';
require_once __DIR__ . '/Repository/EtudiantRepository.php';



$connexion = new Connextion();

$pdo = $connexion->getConnextion();

$departmentRepository = new DepartmentRepository($pdo);
$loginService = new LoginService($pdo);
$coursRepository = new CourseRepository($pdo);
$formateurRepository = new FormateurRepository($pdo);
$etudiantRepository = new EtudiantRepository($pdo);


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
        echo "\n---------------------------------------";
        echo "\n     ==** gestion des universités **==\n";
        echo "     1- gestion des departements.\n";
        echo "     2- gestion des etudiants.\n";
        echo "     3- gestion des formateurs\n";
        echo "     4- gestion des cours\n";
        echo "     5- Quitter\n";
        echo "\n====>> : ";

        $choix = trim(fgets(STDIN));
    } else {
        echo "    ==** gestion des universités **==\n";
        echo "    1- consolter votre cours.\n";
        echo "    2- voire votre infos.\n";
        echo "    3- voire votre  formateur\n";
        echo "    4- voire votre  departement\n";
        echo "\n====>> : ";

        $etudChoix = trim(fgets(STDIN));
    }
    switch ($choix) {
        case 1:
            Departement($departmentRepository);
            break;

        case 2:
            Etudiant($coursRepository, $etudiantRepository);
            break;
        case 3:
            Formateur($formateurRepository);
            break;
        case 4:
            Coures($coursRepository, $departmentRepository, $formateurRepository);
            break;
        case 5:
            exit;
        default:
            echo "Aucun choix valide\n";
            break;
    }
}
function Departement($departmentRepository)
{
    while (true) {
        echo "\n---------------------------------------";
        echo "\n   === Gestion des départements ===\n";
        echo "\n1- ajouter un deparetement.\n";
        echo "2- supprimer un deparetement.\n";
        echo "3- modifier un  deparetement\n";
        echo "4- Liste des deparetements\n";
        echo "5- quitter\n";
        echo "\n====>> : ";
        $D = trim(fgets(STDIN));

        switch ($D) {

            case 1:
                echo "** Ajouter un département : **\n";
                echo "\nNom du département : ";
                $nameDepartment = trim(fgets(STDIN));

                $department = new Department($nameDepartment);

                $departmentRepository->add($department);

                echo "Departement ajoute par succes\n\n";
                break;
            case 2:
                echo "** suppimer un département : **\n";
                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo $dept['id'] . " | " . $dept['name'];
                    echo "\n";
                }
                echo "\n Saisir Id du département va supprimer : ";
                $departmentID = trim(fgets(STDIN));
                $departmentRepository->delete($departmentID);
                echo "Departement supprimer par succes\n";
                break;
            case 3:
                echo "** Modifer un département : **\n";
                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo $dept['id'] . " | " . $dept['name'];
                    echo "\n";
                }
                echo "\n Saisir Id du département : ";
                $DepartmentID = trim(fgets(STDIN));
                echo "Entrer nouvelle nom du département : ";
                $nameDepartment = trim(fgets(STDIN));

                $departmentRepository->update($nameDepartment, $DepartmentID);

                echo "Departement modifier par succes\n";
                break;
            case 4:
                echo "-------------------------";
                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo $dept['id'] . " | " . $dept['name'];
                    echo "\n";
                }
                echo "-------------------------";
                break;
            case 5:
                return;
            default:
                echo "\n !!! aucune choix !!!!\n";
        }
    }
}
function Coures($coursRepository, $departmentRepository, $formateurRepository)
{
    while (true) {
        echo "\n---------------------------------------";

        echo "\n      === Gestion des cours   ===\n";
        echo "1- ajouter un cours.\n";
        echo "2- supprimer un cours.\n";
        echo "3- modifier un cours\n";
        echo "4- liste des cours\n";
        echo "5- quitter\n";
        echo "\n====>> : ";
        $C = trim(fgets(STDIN));
        switch ($C) {

            case 1:
                echo "\nAjouter un cours :\n";
                echo "\n - saisir tittre de coures : ";
                $titre = trim(fgets(STDIN));
                echo "\n - la listes des departement : \n";

                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $dept['id'] . " | " . $dept['name'];
                }
                echo "\n- Choisir Id de Departement de se cours : ";
                $Iddepartement = trim(fgets(STDIN));
                echo "\n - la listes des formateurs : \n";
                $formtArray = $formateurRepository->selectAll();
                foreach ($formtArray as $formt) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $formt['id'] . " | " . $formt['firstname'] . " | " . $formt['lastname'] . " | " . $formt['email'] . " | " . $formt['specialite'] . ".";
                }
                echo "\nChoisir Id de formateur de se cours : ";
                $Idformateur = trim(fgets(STDIN));
                $coure = new Course($titre, $Iddepartement, $Idformateur);
                $coursRepository->Add($coure);
                echo "\ncours ajoute par succes\n";
                break;
            case 2:
                echo "\n- Supprimer un cours :\n";
                echo "\n ** Choisir ID de cours va supprimer :\n";

                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\"" . $coure['titre'] . "\" | Id de Departement :[" . $coure['department_id'] . "] | Id de formateur :[" . $coure['formateur_id'] . "]";
                    echo "\n";
                }
                echo "====>>";
                $idcours = trim(fgets(STDIN));
                $coursRepository->delete($idcours);

                echo "- Coures etait supprimer par succes\n";
                break;
            case 3:
                echo "\- Modifier un cours :\n";
                echo "\n ** Choisir ID de cours va modifier :\n";

                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\" " . $coure['titre'] . " \" | Id de Departement :[" . $coure['department_id'] . "] | Id de formateur :[" . $coure['formateur_id'] . "]";
                }
                echo "====>>";
                $idcoursmdfier = trim(fgets(STDIN));
                echo "-  Entrer nouvelle titre de cours :\n";
                $titremdfier = trim(fgets(STDIN));
                echo  "-  Saisir new ID de departement de cours :\n";
                $idDepmdfier = trim(fgets(STDIN));
                echo  "-  Saisir new ID de formateur de cours :\n";
                $idfrmtmdfier = trim(fgets(STDIN));
                $coure = new Course($titremdfier, $idDepmdfier, $idfrmtmdfier);

                $coursRepository->update($idcoursmdfier, $coure);

                echo " ==>> !! Coures etait modifier par succes !!!\n";
                break;
            case 4:
                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\"" . $coure['titre'] . "\" | Id de Departement :[" . $coure['department_id'] . "] | Id de formateur :[" . $coure['formateur_id'] . "]";
                }
                echo "\n-------------------------\n";

                break;
            case 5:
                return;
            default:
                echo "\naucune choix\n";
        }
    }
}
function Etudiant($coursRepository, $etudiantRepository)
{
    while (true) {
        echo "\n---------------------------------------";
        echo "\n     === Gestion des étudiants   ===\n";
        echo "1- ajouter un etudiant.\n";
        echo "2- supprimer un etudiant.\n";
        echo "3- modifier un  etudiant\n";
        echo "4- liste des  etudiants\n";
        echo "5- quitter\n";
        echo "\n====>> : ";
        $E = trim(fgets(STDIN));
        switch ($E) {

            case 1:
                echo "\n==========Etudiants========";
                echo "\n Ajouter etudiant :";
                echo "\n- Firstname de etudiant : ";
                $etdFirstname = trim(fgets(STDIN));
                echo "\n- Lastname de etudiant : ";
                $etdLastname = trim(fgets(STDIN));
                echo "\n- Email de etudiant : ";
                $etdEmail = trim(fgets(STDIN));
                echo "\n- Password de etudiant : ";
                $etdPassword = trim(fgets(STDIN));
                echo "\n - Niveau de etudiant : ";
                $etdNiveau = trim(fgets(STDIN));
                echo "\n - CNE de etudiant : ";
                $etdCNE = trim(fgets(STDIN));
                echo "\n =>> Liste des cours peu suiver : ";
                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\"" . $coure['titre'] . "\"";
                }
                echo "\n-------------------------";
                echo "\n=>>>> Choisir ID de cours assigner à l'etudiant : ";
                $coursID = trim(fgets(STDIN));

                $etudiant = new Etudiant($etdFirstname, $etdLastname, $etdEmail, $etdPassword, Role::ETUDIANT, $etdNiveau, $etdCNE, $coursID);
                $etudiantRepository->Add($etudiant);
                echo "\n   !!! Etudiant ajouter par succes  !!!\n";
                break;
            case 2:
                echo "\n==========Etudiants========";
                echo "\n - Choisir ID d'etudiant va supprimer :";
                $etdtArray = $etudiantRepository->selectAll();
                foreach ($etdtArray as $etd) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $etd['id'] . " | " . $etd['firstname'] . " | " . $etd['lastname'] . " | " . $etd['email'] . " | " . $etd['niveau'] . " | " . $etd['CNE'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";
                echo "- tu peu annuler par : 0";
                echo "\n====>> : ";
                $etdID = trim(fgets(STDIN));
                if($etdID==0){
                    break;
                }

                $etudiantRepository->delete($etdID);
                echo "\n !! Etudiant supprimer par succes !!\n";
                break;
            case 3:
                echo "\n==========Etudiants========";
                echo "\n-  Choisir ID d'etudiant va modifier :";
                $etdtArray = $etudiantRepository->selectAll();
                foreach ($etdtArray as $etd) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $etd['id'] . " | " . $etd['firstname'] . " | " . $etd['lastname'] . " | " . $etd['email'] . " | " . $etd['niveau'] . " | " . $etd['CNE'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";
                echo "\n====>> : ";
                $EtdID = trim(fgets(STDIN));
                echo "\n-  Saisir des modifications :";
                echo "\n- Firstname de etudiant : ";
                $newEtdFirstname = trim(fgets(STDIN));
                echo "\n- Lastname de etudiant : ";
                $newEtdLastname = trim(fgets(STDIN));
                echo "\n- Email de etudiant : ";
                $newEtdEmail = trim(fgets(STDIN));
                echo "\n- Password de etudiant : ";
                $newEtdPassword = trim(fgets(STDIN));
                echo "\n-  Niveau de etudiant : ";
                $newEtdNiveau = trim(fgets(STDIN));
                echo "\n-  CNE de etudiant : ";
                $newEtdCNE = trim(fgets(STDIN));
                echo "\n-  liste des cours : ";
                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\"" . $coure['titre'] . "\"";
                }
                echo "\n-------------------------";
                echo "\n=>>>> Entrer ID de cours assigner à l'etudiant : ";
                $newCoursID = trim(fgets(STDIN));
                $etudiant = new Etudiant($newEtdFirstname, $newEtdLastname, $newEtdEmail, $newEtdPassword, Role::ETUDIANT, $newEtdNiveau, $newEtdCNE, $newCoursID);
                $etudiantRepository->update($EtdID, $etudiant);
                echo "\n !! Etudiant modifier par succes !!\n";

                break;
            case 4:
                $etdtArray = $etudiantRepository->selectAll();
                foreach ($etdtArray as $etd) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $etd['id'] . " | " . $etd['firstname'] . " | " . $etd['lastname'] . " | " . $etd['email'] . " | " . $etd['niveau'] . " | " . $etd['CNE'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";
                break;
            case 5:
                return;
            default:
                echo "\naucune choix\n";
        }
    }
}
function Formateur($formateurRepository)
{- 
    while (true) {
        echo "\n      === Gestion des formateurs   ===\n";
        echo "1- ajouter un formateur.\n";
        echo "2- supprimer un formateur.\n";
        echo "3- modifier un  formateur\n";
        echo "4- liste des formateurs\n";
        echo "5- quitter\n";
        echo "\n====>> : ";
        $F = trim(fgets(STDIN));
        switch ($F) {

            case 1:
                echo "\n==========Formateur========";
                echo "\n Ajouter formateur :";
                echo "\n- Firstname de formateur : ";
                $formatFirstname = trim(fgets(STDIN));
                echo "\n- Lastname de formateur : ";
                $formatLastname = trim(fgets(STDIN));
                echo "\n- Email de formateur : ";
                $formatEmail = trim(fgets(STDIN));
                echo "\n- Password de formateur : ";
                $formatPassword = trim(fgets(STDIN));
                echo "\n- Specialité de formateur : ";
                $formatSpecialite = trim(fgets(STDIN));
                $formateur = new Formateur($formatFirstname, $formatLastname, $formatEmail, $formatPassword, Role::FORMATEUR, $formatSpecialite);
                $formateurRepository->Add($formateur);
                echo "\n   !!! formateur ajoute par succes  !!!\n";
                break;
            case 2:
                echo "\n==========Formateur========";
                echo "\n- Choisir ID de formateur va supprimer :";
                $formtArray = $formateurRepository->selectAll();
                foreach ($formtArray as $formt) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $formt['id'] . " | " . $formt['firstname'] . " | " . $formt['lastname'] . " | " . $formt['email'] . " | " . $formt['specialite'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";
                echo "\n====>> : ";
                $formatID = trim(fgets(STDIN));

                $formateurRepository->delete($formatID);
                echo "\n- formateur supprimer par succes\n";
                break;
            case 3:
                echo "\n==========Formateur========";
                echo "\n- Choisir ID de formateur va modifier :";
                $formtArray = $formateurRepository->selectAll();
                foreach ($formtArray as $formt) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $formt['id'] . " | " . $formt['firstname'] . " | " . $formt['lastname'] . " | " . $formt['email'] . " | " . $formt['password'] . " | " . $formt['specialite'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";
                echo "=====>> :";
                $IdFormatMdf = trim(fgets(STDIN));
                echo "\n- Entrer nouvelle firstname : ";
                $newfirstname = trim(fgets(STDIN));
                echo "\n- Entrer nouvelle lastname : ";
                $newlastname = trim(fgets(STDIN));
                echo "\n- Entrer nouvelle email : ";
                $newemail = trim(fgets(STDIN));
                echo "\n- Entrer nouvelle password : ";
                $newpassword = trim(fgets(STDIN));
                echo "\n- Entrer nouvelle specialité : ";
                $newspecialite = trim(fgets(STDIN));

                $formateur = new Formateur($newfirstname, $newlastname, $newemail, $newpassword, Role::FORMATEUR, $newspecialite);
                $formateurRepository->update($IdFormatMdf, $formateur);

                echo "\nformateur modifier par succes\n";


                break;
            case 4:
                $formtArray = $formateurRepository->selectAll();
                foreach ($formtArray as $formt) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $formt['id'] . " | " . $formt['firstname'] . " | " . $formt['lastname'] . " | " . $formt['email'] . " | " . $formt['specialite'] . ".";
                }
                echo "\n--------------------------------------------------------------\n";

                break;
            case 5:
                return;
            default:
                echo "\naucune choix\n";
        }
    }
}
