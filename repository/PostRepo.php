<?php
    

include_once '../models/Post.php';


class PostRepo {

  // Connexion
  private $connexion;
  private $table = "post";


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
    public function creer($post){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET postDate=:postDate, content=:content";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $post->content=htmlspecialchars(strip_tags($post->content));
        $post->postDate=htmlspecialchars(strip_tags($post->postDate));
       

        // Ajout des données protégées
        $query->bindParam(":content", $post->content);
        $query->bindParam(":postDate", $post->postDate);
  

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
     * Mettre à jour 
     *
     * @return void
     */
    public function modifier($post){
       
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET postDate=:postDate, content=:content WHERE id=:id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        // On sécurise les données
        $post->postDate=htmlspecialchars(strip_tags($post->postDate));
        $post->content=htmlspecialchars(strip_tags($post->content));
        $post->id=htmlspecialchars(strip_tags($post->id));
        
        // On attache les variables
        $query->bindParam(':postDate', $post->postDate);
        $query->bindParam(':content', $post->content);
        $query->bindParam(':id', $post->id);
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}