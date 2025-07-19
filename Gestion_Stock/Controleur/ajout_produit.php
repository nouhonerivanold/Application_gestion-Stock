<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();
$unite = new Unite($bd);


$libelle = $_POST['libelle'];
$prix = $_POST['prix'];
$idUnite = $_POST['unite'];
$qteMin = $_POST['stock_min'];
$image = $_FILES['image'];
$uploadDir = "../Vue/Images/";
$imageName = uniqid() . "_" . basename($image['name']);
$uploadPath = $uploadDir . $imageName;

if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
    $produit = new Produit($bd);
    $Lunite = $unite->lire_unite($idUnite);
    $produit->ajout_produit($libelle=$libelle, $prixU=$prix, $qteMin=$qteMin, $image=$imageName, $idUnite=$idUnite, $unite=$Lunite['intitule']);
    
} else {
    echo "Echec de l'upload de l'image";
}
header("Location: ../Vue/HTML/Produits.php");



?>