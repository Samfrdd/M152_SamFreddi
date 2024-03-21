<?php
/**
 * Auteur : Sam Freddi
 * Date : 21.03.2024
 * Descrition : Page controlleur post, gère le post du l'utilisateur
 * Version 1.0
 */
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
    } else {
        $lastIdPost = -1;
    }

    if (isset(($_FILES["img"]))) {
        for ($i = 0; $i < count($_FILES["img"]["size"]); $i++) {
            $sumFichier += $_FILES["img"]["size"][$i];
        }
    }

    if ($lastIdPost != -1) {
        if ($sumFichier != 0) {
            foreach ($_FILES["img"]["error"] as $key => $error) {
                // Vérifie si le téléchargement du fichier s'est déroulé sans erreur
                if ($error == UPLOAD_ERR_OK) {
                    // Obtient le nom temporaire du fichier téléchargé
                    if (in_array($_FILES["img"]["type"][$key], $video_mime_types)) {
                        $MAX_FILE_SIZE = 20000000; // 20 MO
                    } else {
                        $MAX_FILE_SIZE = 3000000; //Calcul pour transposer les MEGA en KO, maximum de 3MEGA en OCTET = 3 * 1024 * 1024
                    }

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


                                // Modification des dimension de l'image
                                if (exif_imagetype($tmp_name) != false) {
                                    // Chemin de l'image d'origine et de l'image redimensionnée
                                    $source_image = $tmp_name;
                                    $destination_image = $tmp_name;

                                    // Dimensions souhaitées pour l'image redimensionnée
                                    $nouvelle_largeur = 100;
                                    $nouvelle_hauteur = 100;
                                    $ext = $type[$lastId];
                                    // Création de l'image source
                                    if ($ext == 'png') {
                                        $image_source = imagecreatefrompng($source_image);
                                    } elseif ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'webp' || $ext == 'gif') {
                                        $image_source = imagecreatefromjpeg($source_image);
                                    }
                                    // Calcul du ratio
                                    $ratio = imagesx($image_source) / imagesy($image_source);

                                    // Calcul de la nouvelle taille en conservant le ratio
                                    if ($ratio > 1) {
                                        // Image plus large que haute
                                        $nouvelle_largeur = $nouvelle_largeur * $ratio;
                                    } else {
                                        // Image plus haute que large
                                        $nouvelle_hauteur = $nouvelle_hauteur / $ratio;
                                    }

                                    // Création de l'image redimensionnée avec le ratio conservé
                                    $image_resized = imagecreatetruecolor($nouvelle_largeur, $nouvelle_hauteur);
                                    if ($ext == 'png') {
                                        // Création d'une image transparente PNG
                                        $transparent = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                                        imagefill($image_resized, 0, 0, $transparent);
                                        imagesavealpha($image_resized, true);
                                    }


                                    imagecopyresampled($image_resized, $image_source, 0, 0, 0, 0, intval($nouvelle_largeur), intval($nouvelle_hauteur), imagesx($image_source), imagesy($image_source));

                                    $isMoved[$key] = imagejpeg($image_resized, "$uploads_dir/$name" . "_FormatRedimensionne." . $type[$lastId], 100);
                                    if ($isMoved[$key]) {
                                        $resultat = ajouterMedia($name . "_FormatRedimensionne.", $type[$lastId], $lastIdPost);
                                    }
                                } else {
                                    // Image original
                                    // Déplace le fichier téléchargé vers le répertoire de destination avec un nom unique
                                    $isMoved[$key] = move_uploaded_file($tmp_name, "$uploads_dir/$name" . "_original." . $type[$lastId]);

                                    if ($isMoved[$key]) {
                                        $resultat = ajouterMedia($name . "_original.", $type[$lastId], $lastIdPost);
                                    }
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
    }
    if ($lastIdPost != -1) {
        foreach ($isMoved as $key => $value) {
            if (!$value) {
                $erreur = true;
            }
        }

        if ($erreur) {
            EDatabase::rollback();
        } else {
            EDatabase::commit();
            $erreurImage = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-square-fill "></i>
            <div class="mx-3">
            Opération réussi !
            </div>
        </div>';
        }
    } else {
        EDatabase::rollback();
    }
}
