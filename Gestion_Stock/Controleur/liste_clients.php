<?php
include (__DIR__ . "/../Modele/modele.php");

$bd= Database::getInstance();

$client = new Client($bd);

$liste_clients = $client->liste_clients();

// header("Location: ../Vue/HTML/Clients.php?liste_clients=" . $liste_clients);
?>