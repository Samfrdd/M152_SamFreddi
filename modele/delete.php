<?php

/*
* Nom : delete.php
* Auteur : Sam Freddi 
* Date : 06.09.2023
* Version : 1.0
* Description : Page pour delete les informations
*/



/**
 * Fonction  qui  supprime l'un post
 *
 * @param string $idPost
 * @return bool
 */
function deletePost($idPost)
{
    $sql = "DELETE FROM POST
    WHERE idPost=:id";

    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":id" => $idPost));
    } catch (PDOException $e) {
        return false;
    }

    return true;

}




function deleteMedia($idMedia)
{
    $sql = "DELETE FROM MEDIA
    WHERE idMedia=:id";

    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":id" => $idMedia));
    } catch (PDOException $e) {
        return false;
    }

    return true;

}