<?php

class EPost
{

    /**
     * ctor 
     *
     *$email, $pseudo, $nomRole, $id
     */
    public function __construct($InIdPost = "", $InCommentaire = "", $InDateCreation = "", $InDateModification = "")
    {
        $this->id = $InIdPost;
        $this->commentaire = $InCommentaire;
        $this->dateCreation = $InDateCreation;
        $this->dateModification = $InDateModification;

    }

    public $id;
    public $commentaire;
    public $dateCreation;
    public $dateModification;
}

/**
 * Fonction qui récupère les messages 
 * 
 * @return EPost $c
 */
function getAllPost()
{
    $tabBlog = array();
    $sql = "SELECT POST.idPost, POST.commentaire, POST.creationDate, POST.modificationDate
    FROM POST";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute();
    } catch (PDOException $e) {
        return false;
    }
    // On parcoure les enregistrements 
    while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        // On crée l'objet EClient en l'initialisant avec les données provenant
        // de la base de données
        $tabBlog[] = new EPost($row['idPost'], $row['commentaire'],$row['creationDate'], $row['modificationDate']);
        // On place l'objet EClient créé dans le tableau
    }
    // Done
    return $tabBlog;
}


/**
 * Fonction qui retourne un message et ses informations avec son id
 *
 * @param int $id
 * @return EPost $c;
 */
function getMessageById($id){
    $sql = "SELECT POST.idPost, POST.commentaire, POST.creationDate, POST.modificationDate
    FROM POST
    WHERE idPost = :i
    ORDER BY POST.creationDate";
    $statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $statement->execute(array(":i" => $id));
    } catch (PDOException $e) {
        return false;
    }
    // On parcoure les enregistrements 
    while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        // On crée l'objet EClient en l'initialisant avec les données provenant
        // de la base de données
        $c = new EPost($row['idPost'], $row['commentaire'],$row['creationDate'], $row['modificationDate']);
        // On place l'objet EClient créé dans le tableau
    }
    // Done
    return $c;
}