<?php

require_once './modele/getPost.php';
require_once './modele/getMedia.php';




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
    $div .= '<div class="panel panel-default">';
    $div .= '<div class="panel-thumbnail"><img src="'. $chemin . $value->nom . $value->type .'" class="img-responsive"></div>';
    $div .= '<div class="panel-body">';
    $div .= ' <p class="lead">'. $post->commentaire .'</p>';
    $div .= '<p>'. $post->dateCreation.'</p>';
    $div .= '</div></div>';
 
}   