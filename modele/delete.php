<?php





/**
 * Fonction  qui  supprime l'utlisateur
 *
 * @param string $pseudo
 * @return void
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