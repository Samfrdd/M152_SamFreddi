<?php



function ajouterPost($message, $imgName, $imgType){
    $sql = "INSERT INTO post
    (Message)
    VALUES(:m)";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":m" => $message));
    } catch (PDOException $e) {
        return false;
    }


    $sql = "INSERT INTO media
    (nomMedia, typeMedia)
    VALUES(:nom, :type)";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":nom" => $imgName, ":type" => $imgType));
    } catch (PDOException $e) {
        return false;
    }

    // Done
    return true;
}