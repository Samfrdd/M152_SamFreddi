<?php

$uploads_dir = './vue/imgPost';
$message = "";
$erreurMessage = "";
$dateMessage = "";
// Quand on clique sur "Envoyé"
if (isset($_POST["post"])) {

    // Vérification du champs mdp
    if (filter_has_var(INPUT_POST, 'message')) {
        if (strlen($_POST['message']) > 0 && strlen($_POST['message']) < 200) {
            $message = $_POST["message"];
        } else {
            $erreurMessage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-square-fill "></i>
                            <div class="mx-3">
                            Votre message doit contenir entre 0 et 200 caractères !
                            </div>
                        </div>';
        }
    }

 

    foreach ($_FILES["img"]["error"] as $key => $error) {
        // Vérifie si le téléchargement du fichier s'est déroulé sans erreur
        if ($error == UPLOAD_ERR_OK) {
            // Obtient le nom temporaire du fichier téléchargé
            $tmp_name = $_FILES["img"]["tmp_name"][$key];

            // Vérifie le type d'image en utilisant exif_imagetype
            if (exif_imagetype($tmp_name) != false) {
                // Génère un nom unique pour le fichier
                $name = $_FILES["img"]["name"][$key];
                $type = explode(".", $name);
                $lastId = array_key_last($type);
                $name = uniqid();





                $lien_image_original = $uploads_dir . "/" . $name . "_original." . $type[$lastId];
                // Image original
                // Déplace le fichier téléchargé vers le répertoire de destination avec un nom unique
                move_uploaded_file($tmp_name, "$uploads_dir/$name" . "_original." . $type[$lastId]);
            }
        }
    }


    require_once './modele/insertPost.php';

    if($erreurMessage == ""){
        ajouterPost($message, $name . "_original.", $type[$lastId]);
    }


}
