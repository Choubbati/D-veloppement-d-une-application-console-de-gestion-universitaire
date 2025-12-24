<?php
require 'database/Connextion.php'; 

$connexion = new Connextion();

try {
    $pdo = $connexion->getConnextion();
    echo "success";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
