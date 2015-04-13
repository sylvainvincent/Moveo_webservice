﻿<?php
/** 
 * Chaque requête sera identifier par TAG
 * Les réponses seront données en JSON
 */
// Attention utiliser GET pour verifier directement en HTTP et utiliser POST pour l'appli
// Verification des requetes sous la forme de GET 
if (isset($_GET['tag']) && $_GET['tag'] != '') {
    // RECUPERER LE TAG
    $tag = $_GET['tag'];

	// IMPORTER LES FONCTIONS DE LA CLASSE DB_TripFunctions
	require_once 'include/DB_FriendFunctions.php';
	$friendfunc = new DB_FriendFunctions();

    // Tableau associatif qui sera envoyé au JSON
    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    // Verification des TAGS
	switch ($tag){
		case 'addFriend':
		
			// les informations des champs "email" et "mot de passe" du formulaire de connexion
			$friend_id = $_GET['friend_id'];
			$user_id = $_GET['user_id'];

			// verifier si l'utilisateur existe
			$result = $friendfunc->addFriend($user_id, $friend_id);
			if ($result != false) {
				// L'utilisateur existe : echo json avec success = 1
				$response["success"] = 1;
				$response["message"] = "Ami enregistré avec succès";
				echo json_encode($response);
			}else{
				// l'utilisateur n'existe pas : echo json avec error = 1
				$response["error"] = 1;
				$response["error_msg"] = "Ami non ajouté";
				echo json_encode($response);
			} 
			BREAK;
			
		case 'getFriendsList': 
        
			$user_id = $_GET['user_id'];
			$result = $friendfunc->getFriendsList($user_id);
			foreach($result as $row){
				 $response[] = array('friend_name' => $row['user_name'],
									 'friend_firstname' => $row['user_firstname'],
									 'friend_is_accepted' => $row['is_accepted']
								 );
			}
			$response["success"] = 2;
			echo json_encode($response);
			BREAK;
			
		case 'acceptFriend': 
			$friend_id = $_GET['friend_id'];
			$user_id = $_GET['user_id'];
			
			$result = $friendfunc->acceptFriend($user_id, $friend_id);
			
			if ($result != false) {
	
				$response["success"] = 1;
				$response["message"] = "La demande d'amis a été accepter";
				echo json_encode($response);
			}else{
				
				$response["error"] = 1;
				$response["error_msg"] = "Erreur lors de l'acceptation de la demande";
				echo json_encode($response);
			} 
			BREAK;
			
		case 'removeFriend': 
			$friend_id = $_GET['friend_id'];
			$user_id = $_GET['user_id'];
			
			$result = $friendfunc->removeFriend($user_id, $friend_id);
			
			if ($result != false) {
	
				$response["success"] = 1;
				$response["message"] = "L'ami a été supprimé";
				echo json_encode($response);
				
			}else{
				
				$response["error"] = 1;
				$response["error_msg"] = "Erreur lors de la suppression";
				echo json_encode($response);
				
			} 
			BREAK;
		
		default : 
			echo "Requête invalide";
    }
} else {
    echo "Accès refusé";
}
?>
