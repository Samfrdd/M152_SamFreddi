<?php

require_once './modele/getPost.php';
require_once './modele/getMedia.php';


$video_mime_types = ['mp4', 'webm', 'ogg'];
$audio_mime_types = ['mpeg', 'wav', 'mp3', 'ogg'];

$allPost = "";
$allMedia = "";

$allPost = getAllPost();

$allMedia = getAllMedia();

$div = "";
$chemin = "./vue/imgPost/";

// <div class="panel panel-default">
// <div class="panel-thumbnail"><img src="./vue/css/img/bg_4.jpg" class="img-responsive"></div>
// <div class="panel-body">
//     <p class="lead">Social Good</p>
//     <p>1,200 Followers, 83 Posts</p>

//     <p>
//         <img src="./vue/css/img/photo.jpg" height="28px" width="28px">
//         <img src="./vue/css/img/photo.png" height="28px" width="28px">
//         <img src="./vue/css/img/photo_002.jpg" height="28px" width="28px">
//     </p>
// </div>
// </div>


foreach ($allMedia as $key => $value) {



    $post = getMessageById($value->idPost);

    if(in_array($value->type, $video_mime_types)){
        $div .= '<div class="panel panel-default">';
        $div .= '<div class="panel-thumbnail">';
        

        $div .= '<video class="img-responsive " autoplay loop controls muted>';
    
        $div .= '<source class="" src="'.$chemin . $value->nom . $value->type.'" type="video/'. $value->type.'">';
        
    
        $div .= '</video>';
        $div .= '</div>';
        $div .= '<div class="panel-body">';
        $div .= ' <p class="lead">'. $post->commentaire .'</p>';
        $div .= '<p>'. $post->dateCreation.'</p>';
        $div .= '<form action="#" method POST> <input type="submit" name="delete" value="supprimer"></input></form>';
        $div .= '<form action="#" method POST> <input type="submit" name="modifier" value="modifier"></input></form>';
        $div .= '</div></div>';

    }else if(in_array($value->type, $audio_mime_types)){
        $div .= '<div class="panel panel-default">';
        $div .= '<div class="media">';

        $div .= '<audio class="align-self-center mr-3" controls>';

        $div .='  <source src="'.$chemin . $value->nom . $value->type.'" type="audio/'. $value->type.'">';
        
        $div .='  </audio>';
        $div .='  </div>';
        
        $div .= '<div class="panel-body">';
        $div .= ' <p class="lead">'. $post->commentaire .'</p>';
        $div .= '<p>'. $post->dateCreation.'</p>';
        $div .= '<form action="#" method POST> <input type="submit" name="delete" value="supprimer"></input></form>';
        $div .= '<form action="#" method POST> <input type="submit" name="modifier" value="modifier"></input></form>';


        $div .= '</div></div>';
    
    }else{
        $div .= '<div class="panel panel-default">';
        $div .= '<div class="panel-thumbnail"><img src="'. $chemin . $value->nom . $value->type .'" class="img-responsive"></div>';
        $div .= '<div class="panel-body">';
        $div .= ' <p class="lead">'. $post->commentaire .'</p>';
        $div .= '<p>'. $post->dateCreation.'</p>';
        $div .= '<form action="#" method POST> <input type="submit" name="delete" value="supprimer"></input></form>';
        $div .= '<form action="#" method POST> <input type="submit" name="modifier" value="modifier"></input></form>';
        $div .= '</div></div>';
    }

  
 
}   