<?php
require_once 'Avion.class.php';
require_once 'ManagerAvion.class.php';

$manager = new ManagerAvion();

// Création de quelques avions
$avion1 = new Avion('F4U Corsair', 'Etats-Unis', 1943, 'Chance Vought Aircraft Division');
$avion2 = new Avion('Spitfire', 'Royaume-Uni', 1938, 'Supermarine');
$avion3 = new Avion('Mitsubishi Zero', 'Japon', 1940, 'Mitsubishi Heavy Industries');

// Ajout des avions à la collection
$manager->add($avion1);
$manager->add($avion2);
$manager->add($avion3);

// Récupérer tous les avions
$avions = $manager->getAll();
foreach ($avions as $avion) {
    echo "Avion : " . $avion->getNom() . ", Origine : " . $avion->getPaysOrigine() . ", Mise en service : " . $avion->getAnneeMiseEnService() . ", Constructeur : " . $avion->getConstructeur() . "<br/>";
}

// Supprimer un avion
$manager->remove(2);

// Récupérer tous les avions après suppression
echo "<br>Liste des avions après suppression :<br>";
$avions = $manager->getAll();
foreach ($avions as $avion) {
    echo "Avion : " . $avion->getNom() . ", Origine : " . $avion->getPaysOrigine() . ", Mise en service : " . $avion->getAnneeMiseEnService() . ", Constructeur : " . $avion->getConstructeur() . "<br/>";
}





?>