<?php
include (__DIR__ . "/../Modele/modele.php");

$bd= Database::getInstance();

$nom = $_POST['nom'];
$telephone = $_POST['telephone'];
$ville = $_POST['ville'];
$quartier = $_POST['quartier'];

$fournisseur = new Fournisseur($bd);

$fournisseur->ajout_fournisseur($nom, $telephone, $ville, $quartier);

header('Location: ../Vue/HTML/Fournisseur.php');

?>