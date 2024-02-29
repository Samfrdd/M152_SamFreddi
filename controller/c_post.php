<?php
require_once './modele/db/database.php';


require_once './modele/getPost.php';

require_once './modele/insertPost.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$MAX_FILE_SIZE = 3000000; //Calcul pour transposer les MEGA en KO, maximum de 3MEGA en OCTET = 3 * 1024 * 1024
$MAX_POST_SIZE = 70000000; //Idem que au dessus -> PAS DE *1024 CAR CRéER UN CONFLIT AVEC .HTACCESS !
$video_mime_types = ['video/mp4', 'video/webm', 'video/ogg'];
$audio_mime_types = ['audio/mpeg', 'audio/wav', 'audio/mp3', 'audio/ogg'];


$uploads_dir = './vue/imgPost';
$message = "";
$erreurMessage = "";
$erreurImage = "";
$dateMessage = "";
$image = false;
$resultat = "";
$erreur = false;
$isMoved = [];
$sumFichier = 0;
// Quand on clique sur "Envoyé"
if (isset($_POST["message"])) {

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

    EDatabase::begintransaction();


    if ($erreurMessage == "") {
        $lastIdPost = ajouterPost($message);
    }

    for ($i = 0; $i < count($_FILES["img"]["size"]); $i++) {
        $sumFichier += $_FILES["img"]["size"][$i];
    }
    if ($sumFichier != 0) {
        foreach ($_FILES["img"]["error"] as $key => $error) {
            // Vérifie si le téléchargement du fichier s'est déroulé sans erreur
            if ($error == UPLOAD_ERR_OK) {
                // Obtient le nom temporaire du fichier téléchargé
                $tmp_name = $_FILES["img"]["tmp_name"][$key];
                if ($sumFichier < $MAX_POST_SIZE) {
                    if ($_FILES["img"]["size"][$key] < $MAX_FILE_SIZE) {
                        // Vérifie le type d'image en utilisant exif_imagetype
                        if (exif_imagetype($tmp_name) != false || in_array($_FILES["img"]["type"][$key], $video_mime_types) || in_array($_FILES["img"]["type"][$key], $audio_mime_types)) {
                            // Génère un nom unique pour le fichier
                            $name = $_FILES["img"]["name"][$key];
                            $type = explode(".", $name);
                            $lastId = array_key_last($type);
                            $name = uniqid();

                            $image = true;

                            $lien_image_original = $uploads_dir . "/" . $name . "_original." . $type[$lastId];
                            // Image original
                            // Déplace le fichier téléchargé vers le répertoire de destination avec un nom unique
                            $isMoved[$key] = move_uploaded_file($tmp_name, "$uploads_dir/$name" . "_original." . $type[$lastId]);

                            if ($isMoved[$key]) {
                                $resultat = ajouterMedia($name . "_original.", $type[$lastId], $lastIdPost);
                            }
                        } else {
                            $erreur = true;
                            $erreurImage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-square-fill "></i>
                        <div class="mx-3">
                        Le fichier n a pas la bonne extension ! 
                        </div>
                    </div>';
                        }
                    } else {
                        $erreur = true;
                        $erreurImage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-square-fill "></i>
                    <div class="mx-3">
                    Fichier trop volumineux !
                    </div>
                </div>';
                    }
                } else {
                    $erreur = true;
                    $erreurImage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-square-fill "></i>
                <div class="mx-3">
                Fichier trop volumineux !
                </div>
            </div>';
                }
            } else {
                $erreur = true;
                $erreurImage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-square-fill "></i>
            <div class="mx-3">
           Une erreur est survenu ! 
            </div>
        </div>';
            }
        }
    }
    if ($lastIdPost) {
        foreach ($isMoved as $key => $value) {
            if (!$value) {
                $erreur = true;
            }
        }

        if ($erreur) {
            EDatabase::rollback();
        } else {
            EDatabase::commit();
            echo '{ "ReturnCode": 0, "Message": "Nom et mot de passe correspondent."}';

            exit();
        }
    } else {
        EDatabase::rollback();
    }
}
