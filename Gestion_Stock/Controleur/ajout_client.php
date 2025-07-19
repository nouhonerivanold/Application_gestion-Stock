<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$ville = $_POST['ville'];
$quartier = $_POST['quartier'];

$client = new Client($bd);

$client->ajout_client($nom, $prenom, $telephone, $ville, $quartier);

header("Location: ../Vue/HTML/Client.php");
?>