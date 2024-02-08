<?php

$idPost = "";
$erreurModification = "";
$uploads_dir = './vue/imgPost/';


require_once './modele/delete.php';
require_once './modele/getMedia.php';
require_once './modele/insertPost.php';

if (isset($_POST["modification"])) {
    EDatabase::begintransaction();

    if (filter_has_var(INPUT_POST, 'idPost')) {
        if ($_POST["idPost"] != "") {
            $idPost = $_POST["idPost"];
        } else {
            $erreurModification = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-square-fill "></i>
                            <div class="mx-3">
                            Erreur de la modification
                            </div>
                        </div>';
        }
    }




    if ($erreurSupression == "") {
        $mediaByPost =  getMediaByIdPost($idPost);



        foreach ($mediaByPost as $key => $media) {
            $isUnlink[$key] = unlink($uploads_dir . $media->nom . $media->type);

            $deleteAllMedia[$key] = deleteMedia($media->id);
        }

        $isPostDelete = deletePost($idPost);





        if ($isPostDelete) {
            foreach ($isUnlink as $key => $value) {
                if (!$value) {
                    $erreurLink = true;
                }
            }

            foreach ($deleteAllMedia as $key => $value) {
                if (!$value) {
                    $erreurDeleteMedia = true;
                }
            }

            if ($erreurDeleteMedia && $erreurLink) {
                // Erreur dans les delete media ou unlink
                EDatabase::rollback();
            } else {
                
                EDatabase::commit();

            }
        } else {
            // erreur delete post
            EDatabase::rollback();
        }
    } else {
        EDatabase::rollback();
    }
}
