<?php
$idMedia = "";
$idPost = "";
$erreurModification = "";
$erreurDeletePhoto = "";
$erreurDeletePhoto = "";
$erreurMessage = "";
$erreurImage = "";
$isMediaDeleted = false;
$isModifiy = "";
$sumFichier = 0;
$isMoved = [];
$erreur = false;


$uploads_dir = './vue/imgPost/';
$div = "";
$video_mime_types_display = ['mp4', 'webm', 'ogg'];
$audio_mime_types_display = ['mpeg', 'wav', 'mp3', 'ogg'];
$MAX_FILE_SIZE = 3000000; //Calcul pour transposer les MEGA en KO, maximum de 3MEGA en OCTET = 3 * 1024 * 1024
$MAX_POST_SIZE = 70000000; //Idem que au dessus -> PAS DE *1024 CAR CRéER UN CONFLIT AVEC .HTACCESS !
$video_mime_types = ['video/mp4', 'video/webm', 'video/ogg'];
$audio_mime_types = ['audio/mpeg', 'audio/wav', 'audio/mp3', 'audio/ogg'];
$chemin = "./vue/imgPost/";


require_once './modele/delete.php';
require_once './modele/getMedia.php';
require_once './modele/getPost.php';
require_once './modele/insertPost.php';

$idPost = htmlspecialchars($_GET["id"]);


function displayPhoto($div, $mediaByPost, $video_mime_types, $audio_mime_types, $chemin, $message)
{
    $div .= '<div class="panel panel-default">';
    $div .= '<div class="row">';

    foreach ($mediaByPost as $cle => $media) {
        if (in_array($media->type, $video_mime_types)) {
            $div .= '<div class="panel-thumbnail">';
            $div .= '<video class="video-responsive " autoplay loop controls muted>';
            $div .= '<source class="" src="' . $chemin . $media->nom . $media->type . '" type="video/' . $media->type . '">';
            $div .= '</video>';
            $div .= '</div>';
        } else if (in_array($media->type, $audio_mime_types)) {

            $div .= '<div class="media">';

            $div .= '<audio class="align-self-center mr-3" controls>';

            $div .= '  <source src="' . $chemin . $media->nom . $media->type . '" type="audio/' . $media->type . '">';

            $div .= '  </audio>';
            $div .= '  </div>';
        } else {

            $div .= '<div class="img-thumbnail"><img src="' . $chemin . $media->nom . $media->type . '" class="img-responsive"></div>';
        }
        $div .= '<form action="#" method="POST"> <input type="submit" name="deletePhoto" value="supprimer"></input>';
        $div .= '<input type="hidden" name="idMedia" value="' . $media->id . '"></input>';
        $div .= '</form>';
    }
    $div .= '</div>';



    $div .= '</div>';

    return $div;
}





if (isset($_POST["deletePhoto"])) {
    EDatabase::begintransaction();

    if (filter_has_var(INPUT_POST, 'idMedia')) {
        if ($_POST["idMedia"] != "") {
            $med = "";
            $idMedia = $_POST["idMedia"];
            $med = GetMEdiaByIdMedia($idMedia);
            $isMediaDeleted  = deleteMedia($idMedia);
            $isUnlink = unlink($uploads_dir . $med->nom . $med->type);
        } else {
            $erreurDeletePhoto = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-square-fill "></i>
                            <div class="mx-3">
                            Erreur delete photo
                            </div>
                        </div>';
        }
    }




    if ($erreurDeletePhoto == "") {
        if ($isUnlink && $isMediaDeleted) {
            EDatabase::commit();
            $erreurDeletePhoto = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-square-fill "></i>
            <div class="mx-3">
            Supression d image réussi !
            </div>
        </div>';
        } else {
            EDatabase::rollback();
        }
    } else {
        EDatabase::rollback();
    }
}

if (isset($_POST["modify"])) {
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
        $isModifiy = modifierPost($idPost, $message);
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
                                $resultat = ajouterMedia($name . "_original.", $type[$lastId], $idPost);
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


    if ($isModifiy) {
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


$mediaByPost =  getMediaByIdPost($idPost);
$message = getMessageById($idPost);

$div = displayPhoto($div, $mediaByPost, $video_mime_types_display, $audio_mime_types_display, $chemin, $message);
