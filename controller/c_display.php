<?php

/**
 * Auteur : Sam Freddi
 * Date : 21.03.2024
 * Descrition : Page controlleur display, gère l'affichage de tous les post
 * Version 1.0
 */
require_once './modele/getPost.php';
require_once './modele/getMedia.php';

$div = "";

$div = displayPost($div);
function displayPost($div)
{
    $video_mime_types = ['mp4', 'webm', 'ogg'];
    $audio_mime_types = ['mpeg', 'wav', 'mp3', 'ogg'];

    $allPost = "";
    $allMedia = "";
    $mediaByPost = "";

    $allPost = getAllPost();

    $allMedia = getAllMedia();


    $chemin = "./vue/imgPost/";


    foreach ($allPost as $key => $post) {
        $mediaByPost =  getMediaByIdPost($post->id);
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
        }
        $div .= '</div>';

        $div .= '<div class="panel-body">';
        $div .= ' <p class="lead">' . $post->commentaire . '</p>';
        $div .= '<p>' . $post->dateCreation . '</p>';
        $div .= '</div>';

        $div .= '<button type="submit" class="btn-icon" name="delete" onclick="deletePost(' . $post->id . ')" value="delete"><i class="fa-solid fa-circle-xmark"></i></button>';
        $div .= '<input type="hidden" name="idPost" value="' . $post->id . '"></input>';
        $div .= '';



        $div .= '<a class="btn" href="?page=modification&id=' . $post->id . '" role="button" data-toggle="modal"><i class="fa-solid fa-pen"></i></a>';

        $div .= '</div>';
    }

    return $div;
}
