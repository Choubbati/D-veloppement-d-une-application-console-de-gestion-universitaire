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

echo $f1;
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo $e1;
