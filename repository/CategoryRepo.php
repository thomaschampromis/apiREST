<?php
    

include_once '../models/Category.php';


class CategoryRepo {

  // Connexion
  private $connexion;
  private $table = "category";


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
    public function creer($category){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET label=:label";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $category->label=htmlspecialchars(strip_tags($category->label));
        

        // Ajout des données protégées
        $query->bindParam(":label", $category->label);
      
  
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
    public function supprimer($category){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $category->id=htmlspecialchars(strip_tags($category->id));

        // On attache l'id
        $query->bindParam(1, $category->id);

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
    public function modifier($category){
       
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET label=:label WHERE id=:id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        // On sécurise les données
       
        $category->label=htmlspecialchars(strip_tags($category->label));
        $category->id=htmlspecialchars(strip_tags($category->id));
       
        // On attache les variables
        $query->bindParam(':label', $category->label);
        $query->bindParam(':id', $category->id);
       
        
        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }
}