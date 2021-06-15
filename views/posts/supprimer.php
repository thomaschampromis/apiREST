<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';
    include_once '../../repository/PostRepo.php';


    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les objets
    $post = new Post();
    $postRepo = new PostRepo($db);

    // On récupère l'id du post
    $donnees = json_decode(file_get_contents("php://input"));
   

    if(!empty($donnees->id)){
        $post->id = $donnees->id;
       

        if($postRepo->supprimer($post)){
            // Ici la suppression a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "user deleted"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "User not deleted"]);         
        }
    }

else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
}