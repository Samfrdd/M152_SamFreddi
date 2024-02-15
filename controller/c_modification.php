<?php
$idMedia = "";
$idPost = "";
$erreurModification = "";
$erreurDeletePhoto = "";
$isMediaDeleted = false;

$uploads_dir = './vue/imgPost/';
$div = "";
$video_mime_types = ['mp4', 'webm', 'ogg'];
$audio_mime_types = ['mpeg', 'wav', 'mp3', 'ogg'];

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
        } else {
            EDatabase::rollback();
        }
    } else {
        EDatabase::rollback();
    }
}

if (isset($_POST["goToModif"])) {
}


$mediaByPost =  getMediaByIdPost($idPost);
$message = getMessageById($idPost);

$div = displayPhoto($div, $mediaByPost, $video_mime_types, $audio_mime_types, $chemin, $message);
