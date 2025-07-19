<?php

include ("../Modele/modele.php");
   
$bd= Database::getInstance();

$email = $_POST['email'];
$mot_passe = $_POST['password'];

$employe = new Employe($bd);

$employeConnect = $employe->connexion($email, $mot_passe);
if (!$employeConnect) {
    header("Location: ../Vue/HTML/Connexion.html?error=Identifiants invalides ". $employeConnect);
    exit();
}
else{
    header("Location: ../Vue/HTML/Accueil.php?nom=". $employeConnect['nom'] . "&prenom=" . $employeConnect['prenom'] . "&role=" . $employeConnect['role'] . "&photo=" . $employeConnect['photo']);
}

?>