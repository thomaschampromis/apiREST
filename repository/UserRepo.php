<?php
    

include_once '../models/User.php';


class UserRepo {

  // Connexion
  private $connexion;
  private $table = "user";


    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des produits
     *
     * @return void
     */
    public function lire(){
        // On écrit la requête
        $sql = "SELECT * FROM " . $this->table;

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Créer un produit
     *
     * @return void
     */
    public function creer($user){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET email=:email, password=:password, birthDate=:birthDate";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $user->email=htmlspecialchars(strip_tags($user->email));
        $user->password=htmlspecialchars(strip_tags($user->password));
        $user->birthDate=htmlspecialchars(strip_tags($user->birthDate));
       

        // Ajout des données protégées
        $query->bindParam(":email", $user->email);
        $query->bindParam(":password", $user->password);
        $query->bindParam(":birthDate", $user->birthDate);
  

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

   
    /**
     * Supprimer un produit
     *
     * @return void
     */
    public function supprimer($post){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $post->id=htmlspecialchars(strip_tags($post->id));

        // On attache l'id
        $query->bindParam(1, $post->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour un produit
     *
     * @return void
     */
    public function modifier($user){
       
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET email=:email, password=:password, birthDate=:birthDate WHERE id=:id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        // On sécurise les données
        $user->email=htmlspecialchars(strip_tags($user->email));
        $user->password=htmlspecialchars(strip_tags($user->password));
        $user->birthdate=htmlspecialchars(strip_tags($user->birthdate));
        $user->id=htmlspecialchars(strip_tags($user->id));
        
        // On attache les variables
        $query->bindParam(':email', $user->email);
        $query->bindParam(':password', $user->password);
        $query->bindParam(':birthDate', $user->birthDate);
        $query->bindParam(':id', $user->id);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}