<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../../config/Database.php';
    include_once '../../models/User.php';
    include_once '../../repository/UserRepo.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les objets
    $user = new User();
    $userRepo = new UserRepo($db);

    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));

    var_dump($donnees); 
   
    
    if(!empty($donnees->email) && !empty($donnees->password) && !empty($donnees->birthDate)){

        // Ici on a reçu les données
        // On hydrate notre objet
        $user->email = $donnees->email;
        $user->password = $donnees->password;
        $user->birthDate = $donnees->birthDate;

        if($userRepo->creer($user)){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "User added"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "User not added"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}