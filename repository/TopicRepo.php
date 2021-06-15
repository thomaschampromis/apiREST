<?php
    

include_once '../models/Topic.php';


class TopicRepo {

  // Connexion
  private $connexion;
  private $table = "topic";


    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture 
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
     * Créer 
     *
     * @return void
     */
    public function creer($topic){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET title=:title";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $topic->title=htmlspecialchars(strip_tags($topic->title));
       
        // Ajout des données protégées
        $query->bindParam(":title", $topic->title);
    
  

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

   
    /**
     * Supprimer 
     *
     * @return void
     */
    public function supprimer($topic){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $topic->id=htmlspecialchars(strip_tags($topic->id));

        // On attache l'id
        $query->bindParam(1, $topic->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour 
     *
     * @return void
     */
    public function modifier($topic){
       
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET title=:title WHERE id=:id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        // On sécurise les données
        $topic->title=htmlspecialchars(strip_tags($topic->title));
        $topic->id=htmlspecialchars(strip_tags($topic->id));
        
        // On attache les variables
        $query->bindParam(':title', $topic->title);
      
        $query->bindParam(':id', $topic->id);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}