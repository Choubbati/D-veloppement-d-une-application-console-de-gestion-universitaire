<?php
require_once __DIR__ . '/Repository/DepartmentRepository.php';
require_once __DIR__ . '/database/Connextion.php';
require_once __DIR__ . '/Service/login.php';
require_once __DIR__ . '/Repository/CourseRepository.php';
require_once __DIR__ . '/Repository/FormateurRepository.php';
require_once __DIR__ . '/Enum/Role.php';
require_once __DIR__ . '/Repository/EtudiantRepository.php';
require_once __DIR__ . '/Repository/Formateur_Coures.php';
require_once __DIR__ . '/Repository//Etudiant_Coures.php';
require_once __DIR__ . '/Repository/UserRepository.php';



$connexion = new Connextion();

$pdo = $connexion->getConnextion();

$departmentRepository = new DepartmentRepository($pdo);
$loginService = new LoginService($pdo);
$coursRepository = new CourseRepository($pdo);
$formateurRepository = new FormateurRepository($pdo);
$etudiantRepository = new EtudiantRepository($pdo);
$formateur_coure = new Formateur_Coures($pdo);
$etudiant_coure = new Etudiant_Course($pdo);
$userRepositiry = new User_Repository($pdo);


do {
    // do {
    echo "===** LOGIN **===\n";
    echo "Entrer votre Email : ";
    $email = trim(fgets(STDIN));
    echo "Entrer votre password : ";
    $password = trim(fgets(STDIN));
    $login = $userRepositiry->login($email, $password);

} while (!$login);

while (true) {
     if($login["role"] === "ADMIN") {
        echo "\n----------------- Bienvenue ----------------------";
        echo "\n     ==** gestion des universités **==\n";
        echo "     1- gestion des departements.\n";
        echo "     2- gestion des etudiants.\n";
        echo "     3- gestion des formateurs\n";
        echo "     4- gestion des cours\n";
        echo "     5- Voire votre Informatios \n";
        echo "     6- Quitter\n";
        echo "\n====>> : ";

        $choix = trim(fgets(STDIN));
    } else {
         if($login["role"] === "ETUDIANT") {
        echo "    ==** gestion des universités **==\n";
        echo "    1- consulter la liste des étudiants par département.\n";
        echo "    2- consulter les cours suivis par un étudian.\n";
        echo "    3- voire votre  formateur\n";
        echo "    4- voire votre  departement\n";
        echo "    6- Quitter\n";
        echo "\n====>> : ";

        $etudChoix = trim(fgets(STDIN));
    }}

    switch ($choix) {
        case 1:
            Departement($departmentRepository);
            break;

        case 2:
            Etudiant($coursRepository, $etudiantRepository, $etudiant_coure, $userRepositiry);
            break;
        case 3:
            Formateur($formateurRepository, $userRepositiry);
            break;
        case 4:
            Coures($coursRepository, $departmentRepository, $formateur_coure, $formateurRepository);
            break;
        case 5:
            AddinsertInfo($userRepositiry);
            break;
        case 6:
            exit;
        default:
            echo "Aucun choix valide\n";
            break;
    }



    switch ($etudChoix) {
        case 1:
            $arrays = $userRepositiry->getEtudiantsByDepartment();
            foreach ($arrays as $aray) {
                echo "\n--------------------------------------------------------------\n";
                echo $aray['department'] . " | " . $aray['firstname'] . " | " . $aray['lasstname'] . " | " . $aray['CNE'] . ".";
            }
            echo "\n-------------------------";
            break;

        case 2:
            $etdtArray = $etudiantRepository->selectAll();
            foreach ($etdtArray as $etd) {
                echo "\n--------------------------------------------------------------\n";
                echo $etd['id'] . " | " . $etd['firstname'] . " | " . $etd['lastname'] . " | " . $etd['email'] . " | " . $etd['niveau'] . " | " . $etd['CNE'] . ".";
            }
            echo "\n--------------------------------------------------------------\n";
            echo "\n ==>> choisir id d'etudiant :  ";
            $iD = trim(fgets(STDIN));
            $arrays = $userRepositiry->getCoursesByEtudiant($iD);
            foreach ($arrays as $aray) {
                echo "\n--------------------------------------------------------------\n";
                echo $aray['course'] . " | " . $aray['department'] . ".";
            }
            echo "\n-------------------------\n";
            var_dump($arrays);
            break;
        case 3:
                echo " merci de pour votre choix \n";

            break;
        case 4:
                echo " merci de pour votre choix \n";

            break;
        case 5:
                echo " merci de pour votre choix \n";

            break;
        case 6:
            return;
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
        echo "3- modier un  deparetement\n";
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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $departmentRepository->add($department);

                echo "Departement ajoute par succes\n";
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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $departmentRepository->update($nameDepartment, $DepartmentID);

                echo "Departement modifier par succes\n";
                break;
            case 4:
                echo "\n-------------------------\n";
                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo $dept['id'] . " | " . $dept['name'];
                    echo "\n";
                }
                echo "-------------------------\n";
                break;
            case 5:
                return;
            default:
                echo "\n !!! aucune choix !!!!\n";
        }
    }
}
function Coures($coursRepository, $departmentRepository, $formateur_coure, $formateurRepository)
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
                echo "\n =>> la listes des departement : \n";


                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $dept['id'] . " | " . $dept['name'];
                }
                echo "\n- Choisir Id de Departement de se cours : ";
                $Iddepartement = trim(fgets(STDIN));
                $department = $departmentRepository->selectById($Iddepartement); 
                $coure = new Course($titre, $department);
                echo "\n =>> la listes des formateurs : \n";
                $formtArray = $formateurRepository->selectAll();
                foreach ($formtArray as $formt) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $formt['id'] . " | " . $formt['firstname'] . " | " . $formt['lastname'] . " | " . $formt['email'] . " | " . $formt['specialite'] . ".";
                }
                echo "\nChoisir Id de formateur de se cours : ";
                $Idformateur = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $idcour = $coursRepository->Add($coure);

                $formateur_coure->add($Idformateur, $idcour);
                echo "\ncours ajoute par succes\n";
                break;
            case 2:
                echo "\n- Supprimer un cours :\n";
                echo "\n ** Choisir ID de cours va supprimer :\n";

                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\"" . $coure['titre'] . "\" | Id de Departement :[" . $coure['department'] . "]";
                    echo "\n";
                }
                echo "====>>";
                $idcours = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $coursRepository->delete($idcours);

                echo "- Coures  supprimer par succes\n";
                break;
            case 3:
                echo "\- Modifier un cours :\n";
                echo "\n ** Choisir ID de cours va modifier :\n";

                $coursArray = $coursRepository->selectAll();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $coure['id'] . " | Titre de cours :\" " . $coure['titre'] . " \" | Id de Departement :[" . $coure['department'] . "]";
                }
                echo "\n====>>";
                $idcoursmdfier = trim(fgets(STDIN));
                echo "-  Entrer nouvelle titre de cours :\n";
                $titremdfier = trim(fgets(STDIN));
                echo "\n";
                $departmentArray = $departmentRepository->selectAll();
                foreach ($departmentArray as $dept) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $dept['id'] . " | " . $dept['name'];
                }
                echo  "\n-  Saisir new ID de departement de cours :\n";
                $idDepmdfier = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $department = $departmentRepository->selectById($idDepmdfier); 
                $coure = new Course($titremdfier, $department);
                $coursRepository->update($idcoursmdfier, $coure);

                echo " ==>> !! Coures etait modifier par succes !!!\n";
                break;
            case 4:
                $coursArray = $coursRepository->selectAllInfos();
                foreach ($coursArray as $coure) {
                    echo "\n--------------------------------------------------------------\n";
                    echo " Titre de cours :\"" . $coure['titre'] . "\" | le formateur :\"" . $coure['firstname']." ".$coure['lastname'] . "\""." et leur specialite :\"" . $coure['specialite'] ."\""." | Id de Departement :[" . $coure['department'] . "]";
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
function Etudiant($coursRepository, $etudiantRepository, $etudiant_coure, $userRepositiry)
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
                echo "\n- Annuler [0] contenue [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $etudiant = new Etudiant($etdFirstname, $etdLastname, $etdEmail, $etdPassword, Role::ETUDIANT, $etdNiveau, $etdCNE);
                $IdInserted = $etudiantRepository->Add($etudiant);
                $etudiant_coure->add($IdInserted, $coursID);
                $userRepositiry->add($etdFirstname, $etdLastname,  $etdEmail,  $etdPassword, "ETUDIANT");


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
                if ($etdID == 0) {
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
                echo "\n- Annuler [0] contenue [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
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
function Formateur($formateurRepository, $userRepositiry)
{
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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $formateurRepository->Add($formateur);
                $userRepositiry->add($formatFirstname, $formatLastname,  $formatEmail,  $formatPassword, "FORMATEUR");

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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
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
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
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

function AddinsertInfo($userRepositiry)
{
    while (true) {
        echo "\n---------------------------------------";
        echo "\n   === Sittings ===\n";
        echo "\n1- ajouter un USER.\n";
        echo "2- supprimer un USER.\n";
        echo "3- modier un  USER\n";
        echo "4- Liste des USERs\n";
        echo "5- quitter\n";
        echo "\n====>> : ";
        $D = trim(fgets(STDIN));

        switch ($D) {

            case 1:
                echo "\n========== ADMIN SITTINGS ========";
                echo "\n Ajouter autre admin :";
                echo "\n- Firstname : ";
                $firstname = trim(fgets(STDIN));
                echo "\n- Lastname : ";
                $lastname = trim(fgets(STDIN));
                echo "\n- Email : ";
                $email = trim(fgets(STDIN));
                echo "\n- Password  : ";
                $password = trim(fgets(STDIN));
                echo "\n- Role  (ADMIN, FORMATEUR, ETUDIANT): ";
                $role = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $userRepositiry->add($firstname, $lastname,  $email,  $password, $role);
                echo "\n   !!! Admin ajouter par succes  !!!\n";

                break;
            case 2:
                echo "\n========== ADMIN SITTINGS ========";
                echo "\n** suppimer un users : **\n";
                echo "\n- liste des utilisateurs : ";
                $arrays = $userRepositiry->selectAll();
                foreach ($arrays as $aray) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $aray['id'] . " | " . $aray['firstname'] . " | " . $aray['lasstname'] . " | " . $aray['email'] . " | " . $aray['firstname'] . ".";
                }
                echo "\n-------------------------";
                echo "\n=> choisir id de utilisateur";
                echo "\n===>>> : ";
                $idSuprm = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $userRepositiry->delete($idSuprm);
                echo "\n   !!! Admin ajouter par succes  !!!\n";

                break;
            case 3:
                echo "\n========== ADMIN SITTINGS ========";
                echo "\n** Moder un user : **";
                echo "\n-==> liste des users : ";
                $arrays = $userRepositiry->selectAll();
                foreach ($arrays as $aray) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $aray['id'] . " | " . $aray['firstname'] . " | " . $aray['lasstname'] . " | " . $aray['email'] . " | " . $aray['firstname'] . ".";
                }
                echo "\n-------------------------";
                echo "\n=> choisir id de utilisateur";
                echo "\n===>>> : ";
                $idmdf = trim(fgets(STDIN));
                echo "\n- Firstname : ";
                $firstname = trim(fgets(STDIN));
                echo "\n- Lastname : ";
                $lastname = trim(fgets(STDIN));
                echo "\n- Email : ";
                $email = trim(fgets(STDIN));
                echo "\n- Password  : ";
                $password = trim(fgets(STDIN));
                echo "\n- Role  : ";
                $role = trim(fgets(STDIN));
                echo "\n- Annuler [0] contenuer [1]";
                $w = trim(fgets(STDIN));
                if ($w == 0) {
                    break;
                }
                $userRepositiry->update($idmdf, $firstname, $lastname, $email, $password,  $role);


                echo "Departement modier par succes\n";
                break;
            case 4:
                echo "\n-==> liste des users : ";
                $arrays = $userRepositiry->selectAll();
                var_dump($arrays);
                exit;
                foreach ($arrays as $aray) {
                    echo "\n--------------------------------------------------------------\n";
                    echo $aray['id'] . " | " . $aray['firstname'] . " | " . $aray['lasstname'] . " | " . $aray['email'] . " | " . $aray['role'] . ".";
                }
                echo "\n-------------------------";
                break;
            case 5:
                return;
            default:
                echo "\n !!! aucune choix !!!!\n";
        }
    }
}
