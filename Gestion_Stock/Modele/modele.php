<?php
class Database {
    private static $instance = null;
    private $host = "localhost";
    private $dbname = "GestionStock";
    private $username = "postgres";
    private $password = "m@ri@fern@nd@";
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "pgsql:host=localhost;port=5433;dbname=GestionStock", 
                "postgres", 
                "m@ri@fern@nd@"
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}

class Produit {
    private $conn;
    public $libelle;
    public $prixU;
    public $qteStock;
    public $qteMin;
    public $image;
    public $idUnite;
    public $unite;
    public $idProduitRef;
    private $table = "Produit";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_produit($libelle, $prixU, $qteMin, $image, $idUnite, $unite, $qteStock=0, $idProduitRef = null) {
        $sql = "INSERT INTO {$this->table} (libelle, prixU, qteStock, qteMin, image, idUnite, unite.intitule, idProduitRef)
                VALUES (:libelle, :prixU, :qteStock, :qteMin, :image, :idUnite, :unite, :idProduitRef)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':libelle' => $libelle,
            ':prixU' => $prixU,
            ':qteStock' => $qteStock,
            ':qteMin' => $qteMin,
            ':image' => $image,
            ':idUnite' => $idUnite,
            ':unite' => $unite,
            ':idProduitRef' => $idProduitRef
        ]);
    }

    public function liste_produits() {
        $sql = "SELECT * FROM {$this->table} WHERE idProduitRef IS NULL";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lire_produit($idProduit) {
        $sql = "SELECT * FROM {$this->table} WHERE idProduit = :idProduit";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idProduit' => $idProduit]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lire_produit_unite($idProduit, $idUnite){
        $sql = "SELECT * FROM {$this->table} WHERE (idproduit = :idProduit AND idunite = :idUnite) OR (idproduitRef = :idProduit AND idunite = :idUnite)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idProduit' => $idProduit, ':idUnite' => $idUnite]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fractionner_produit($idProduitRef, $unite, $qte, $prix) {
        
        $produitRef = $this->lire_produit($idProduitRef);
        if (!$produitRef) {
            return false;
        }
        $sql = "INSERT INTO {$this->table} (libelle, prixU, qtestock, qteMin, image, idunite, unite.intitule, idProduitRef)
                VALUES (:libelle, :prixU, :qteStock, :qteMin, :image, :idUnite, :unite, :idProduitRef)";
        $stmt = $this->conn->prepare($sql);
        if ($produitRef['qtestock'] == null) {
            $produitRef['qtestock'] = 0;
        }
        return $stmt->execute([
            ':libelle' => $produitRef['libelle'],
            ':prixU' => $prix,
            ':qteStock' => $produitRef['qtestock'],
            ':qteMin' => $qte,
            ':image' => $produitRef['image'],
            ':idUnite' => $unite['idunite'],
            ':unite' => $unite['intitule'],
            ':idProduitRef' => $idProduitRef
        ]);
    }

    public function produits_fractionnes($idProduitRef) {
        $sql = "SELECT * FROM {$this->table} WHERE idProduitRef = :idProduitRef or idProduit = :idProduitRef";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idProduitRef' => $idProduitRef]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function liste_produits_ruptureStock() {
        $sql = "SELECT * FROM {$this->table} WHERE qteStock<qteMin and idProduitRef IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Client {
    private $conn;
    public $nom;
    public $prenom;
    public $telephone;
    public $ville;
    public $quartier;
    private $table = "Client";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_client($nom, $prenom, $telephone, $ville, $quartier) {
        $sql = "INSERT INTO {$this->table} (nom, prenom, telephone, ville, quartier)
                VALUES (:nom, :prenom, :telephone, :ville, :quartier)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':ville' => $ville,
            ':quartier' => $quartier
        ]);
    }

    public function lire_client($id) {
        $sql = "SELECT * FROM {$this->table} WHERE idClient = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function liste_clients() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class Commande {
    private $conn;
    public $idClient;
    public $date;
    public $statut;
    private $table = "Commande";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_commande($date, $statut="attente", $idClient=NULL) {
        $sql = "INSERT INTO {$this->table} (idclient, date, statut)
                VALUES (:idClient, :date, :statut)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([
            ':idClient' => $idClient,
            ':date' => $date,
            ':statut' => $statut
        ])) {
            return $this->conn->lastInsertId(); 
        } else {
            return false; 
        }
    }
    

    public function liste_commandes() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class LigneCommande {
    public $idProduit;
    public $idCommande;
    public $qte;
    private $table = "LigneCommande";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function existe($idProduit, $idCommande) {
        $sql = "SELECT 1 FROM {$this->table} WHERE idProduit = :idProduit AND idCommande = :idCommande LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':idProduit' => $idProduit,
            ':idCommande' => $idCommande
        ]);
        return $stmt->fetchColumn() !== false;
    }    

    public function ajout_ligneCommande($idProduit, $idCommande, $qte) {
        $sql = "INSERT INTO {$this->table} (idproduit, idcommande, qte) VALUES (:idProduit, :idCommande, :qte)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':idProduit' => $idProduit,
            ':idCommande' => $idCommande,
            ':qte' => $qte
        ]);
    }

    public function lire_ligneCommande($idProduit, $idCommande) {
        if (!$this->existe($idProduit, $idCommande)) {
            return false;
        }
        $sql = "SELECT * FROM {$this->table} WHERE idProduit = :idProduit AND idCommande = :idCommande";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':idProduit' => $idProduit,
            ':idCommande' => $idCommande
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifier_ligneCommande($idProduit, $idCommande, $qte) {
        if (!$this->existe($idProduit, $idCommande)) {
            return false;
        }
        $sql = "UPDATE {$this->table} SET qte = :qte WHERE idProduit = :idProduit AND idCommande = :idCommande";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':qte' => $qte,
            ':idProduit' => $idProduit,
            ':idCommande' => $idCommande
        ]);
    }

    public function supprimer_ligneCommande($idProduit, $idCommande) {
        if (!$this->existe($idProduit, $idCommande)) {
            return false;
        }
        $sql = "DELETE FROM {$this->table} WHERE idProduit = :idProduit AND idCommande = :idCommande";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':idProduit' => $idProduit,
            ':idCommande' => $idCommande
        ]);
    }
}

class FactureClient{
    public $idClient;
    public $idCommande;
    public $infosClient;
    public $sommePayee;
    public $sommeTotale;
    public $statut;
    public $date;
    private $table = "FactureClient";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function creer_facture($idCommande, $sommePayee, $sommeTotale, $statut, $date, $infosClient=NULL, $idClient=NULL){
        # ici je mets =NULL par defaut pour bien gerer les commandes qui concerneront les client occasionnels c'est a dire ceux qui n'on pas de compte.
        if ($infosClient === null) {
            $infosClient = ['nom' => null, 'prenom' => null, 'phone' => null, 'adresse' => null];
        }
        $sql = "INSERT INTO {$this->table} (idclient, infosclient, idcommande, montantpayee, montanttotale, statut, date) 
            VALUES (:idClient, ROW(:nom, :prenom, :phone, :ville, :quartier), :idCommande, :sommePayee, :sommeTotale, :statut, :date)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':idClient' => $idClient,
            ':nom' => $infosClient['nom'],
            ':prenom' => $infosClient['prenom'],
            ':phone' => $infosClient['phone'],
            ':ville' => $infosClient['adresse'],
            ':quartier' => $infosClient['adresse'],
            ':idCommande' => $idCommande,
            ':sommePayee' => $sommePayee,
            ':sommeTotale' => $sommeTotale,
            ':statut' =>  $statut,
            ':date' =>  $date
        ]);
    }

    // public function creer_facture() {
    //     // Valeurs statiques pour l'insertion
    //     $idClient = null; // Client occasionnel
    //     $infosClient = [
    //         'nom' => 'Client',
    //         'prenom' => 'Occasionnel',
    //         'phone' => '0000000000',
    //         'adresse' => 'Adresse inconnue'
    //     ];
    //     $idCommande = 36; // ID de commande statique
    //     $sommePayee = 0; // Aucun paiement initial
    //     $sommeTotale = 1000; // Montant total statique
    //     $statut = 'attente'; // Statut par défaut
    //     $date = date('Y-m-d'); // Date actuelle
    
    //     // Requête SQL
    //     $sql = "INSERT INTO {$this->table} (idclient, infosclient, idcommande, montantpayee, montanttotale, statut, date) 
    //             VALUES (:idClient, ROW(:nom, :prenom, :phone, :adresse), :idCommande, :sommePayee, :sommeTotale, :statut, :date)";
        
    //     try {
    //         $stmt = $this->conn->prepare($sql);
    //         return $stmt->execute([
    //             ':idClient' => $idClient,
    //             ':nom' => $infosClient['nom'],
    //             ':prenom' => $infosClient['prenom'],
    //             ':phone' => $infosClient['phone'],
    //             ':adresse' => $infosClient['adresse'],
    //             ':idCommande' => $idCommande,
    //             ':sommePayee' => $sommePayee,
    //             ':sommeTotale' => $sommeTotale,
    //             ':statut' => $statut,
    //             ':date' => $date
    //         ]);
    //     } catch (PDOException $e) {
    //         error_log("Erreur dans creer_facture : " . $e->getMessage());
    //         return false;
    //     }
    // }

    public function lire_facture($idFacture){
        $sql = "SELECT * FROM {$this->table} WHERE id=$idFacture";
        $stmt = $this->conn->prepare($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function liste_factures(){
        $sql = "SELECT * FROM {$this->table} ORDER BY date DESC LIMIT 10";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function liste_factures_nonCompletes() {
        $sql = "SELECT * FROM {$this->table} WHERE statut != 'totale'";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function modifier_facture($idFacture, $sommePayee){
    //     $statut = "en attente";
    //     $facture = $this->lire_facture($idFacture);
    //     $result = $facture->$sommeTotale - $facture->$sommePayee;
    //     if ($sommePayee == $result) {
    //         $statut = "totale";
    //     }else if($sommePayee < $result){
    //         $statut = "partielle";
    //     }
    //     $sql = "UPDATE FROM {$this->table} SET sommePayee=:somme, statut=:statut WHERE id=$idFacture";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([
    //         ':somme' => $facture->$sommePayee + $sommePayee;
    //         ':statut' => $statut;
    //     ]);
    // }

}

class Employe{
    public $nom;
    public $prenom;
    public $adresse;
    public $telephone;
    public $email;
    public $role;
    public $password;
    public $photo;
    private $table = "Employe";
    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_employe($nom, $prenom, $adresse, $telephone, $email, $role, $mot_passe, $photo){
        $sql = "INSERT INTO {$this->table} (nom, prenom, adresse, telephone, email, role, mot_passe, photo) VALUES (:nom, :prenom, :adresse, :telephone, :email, :role, :mot_passe, :photo)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':adresse' => $adresse,
            ':telephone' => $telephone,
            ':email' => $email,
            ':role' => $role,
            ':mot_passe' => $mot_passe,
            ':photo' => $photo
        ]);
    }

    public function lire_employe($idEmploye) {
        $sql = "SELECT * FROM {$this->table} WHERE idEmploye = :idEmploye";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idEmploye' => $idEmploye]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function connexion($email, $mot_passe) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND mot_passe = :mot_passe";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':mot_passe' => $mot_passe]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class CommandeFournisseur{
    public $idEmploye;
    public $idFournisseur;
    public $date;
    public $statut;
    private $table = "CommandeFournisseur";
    public $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

}

class Lot{
    public $idProduit;
    public $qte;
    public $datePeremption;
    public $dateFabrication;
    private $table = "Lot";
    private PDO $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_lot($idProduit, $qte, $datePeremption, $dateFabrication) {
        $sql = "INSERT INTO {$this->table} (idProduit, qte, datePeremption, dateFabrication)
                VALUES (:idProduit, :qte, :datePeremption, :dateFabrication)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':idProduit' => $idProduit,
            ':qte' => $qte,
            ':datePeremption' => $datePeremption,
            ':dateFabrication' => $dateFabrication
        ]);
    }
}

class Unite{
    public $intitule;
    private $table = "Unite";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_unite($intitule) {
        $sql = "INSERT INTO {$this->table} (intitule) VALUES (:intitule)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':intitule' => $intitule]);
    }

    public function liste_unites() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lire_unite($idUnite) {
        $sql = "SELECT * FROM {$this->table} WHERE idUnite = :idUnite";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idUnite' => $idUnite]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class Fournisseur{
    public $nom;
    public $telephone;
    public $ville;
    public $quartier;
    private $table = "Fournisseur";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajout_fournisseur($nom, $telephone, $ville, $quartier) {
        $sql = "INSERT INTO {$this->table} (nom, telephone, ville, quartier) VALUES (:nom, :telephone, :ville, :quartier)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':telephone' => $telephone,
            ':ville' => $ville,
            ':quartier' => $quartier
        ]);
    }

    public function liste_fournisseurs() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lire_fournisseur($idFournisseur) {
        $sql = "SELECT * FROM {$this->table} WHERE idFournisseur = :idFournisseur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idFournisseur' => $idFournisseur]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
