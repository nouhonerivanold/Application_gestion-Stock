<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$role = $_POST['role'];
$mot_passe = $_POST['password'];
$mot_passe2 = $_POST['confirm-password'];
$photo = $_FILES['photo'];

if ($mot_passe !== $mot_passe2) {
    header("Location: ../Vue/HTML/Compte.html?error=Les mots de passe ne correspondent pas");
    exit();
}

$uploadDir = "../Vue/Images/"; // Répertoire de destination pour les photos
$photoName = uniqid() . "_" . basename($photo['name']);
$uploadPath = $uploadDir . $photoName;

if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
    $employe = new Employe($bd);
    echo "Photo uploaded successfully: " . $photoName;
    $employe->ajout_employe($nom, $prenom, $adresse, $telephone, $email, $role, $mot_passe, $photoName);
    
    header("Location: ../Vue/HTML/Connexion.html");
    exit();
} else {
    header("Location: ../Vue/HTML/Compte.html?error=Echec de l'upload de la photo");
    exit();
}

?>