<?php
/*
* Nom : insertPost.php
* Auteur : Sam Freddi 
* Date : 06.09.2023
* Version : 1.0
* Description : insert les info dans la bdd
*/


function ajouterPost($message)
{
    $sql = "INSERT INTO POST
    (commentaire)
    VALUES(:c)";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":c" => $message));
        $lastInsertedId = EDatabase::lastInsertId();
    } catch (PDOException $e) {
        return false;
    }

    return $lastInsertedId;
}




function ajouterMedia($imgName, $imgType, $id)
{
    $sql = "INSERT INTO MEDIA
    (nomMedia, typeMedia, idPost)
    VALUES(:nom, :type, :id)";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":nom" => $imgName, ":type" => $imgType, ":id" => $id));
    } catch (PDOException $e) {
        return false;
    }
    return "insertion reussi";
}

function modifierPost($idPost, $message)
{
    $sql = "UPDATE POST
    SET commentaire=:m
    WHERE POST.idPost=:i";

    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":i" => $idPost, ":m" => $message));
    } catch (PDOException $e) {
        return false;
    }
    return true;
}
