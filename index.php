<?php


require 'Entity/Formateur.php';
require 'Entity/Etudiant.php';

$f1 = new Formateur(
    1,
    "chouaib",
    "loubbati",
    "choubbati@gmail.com",
    "0610708182"
);

$e1 = new Etudiant(
    1,
    "jamal",
    "kam",
    "ati@gmail.com",
    "0610708182"
);

echo 'vous avez un ' . $f1->getRole() . PHP_EOL;


echo $e1->getRole() . PHP_EOL;
