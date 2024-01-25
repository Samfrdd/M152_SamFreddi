<?php

class EMedia
{

    /**
     * ctor 
     *
     *$email, $pseudo, $nomRole, $id
     */
    public function __construct($InIdMedia = "", $InNomMedia = "", $InTypeMedia = "", $InDateCreation = "", $InIdPost = "")
    {
        $this->id = $InIdMedia;
        $this->nom = $InNomMedia;
        $this->type = $InTypeMedia;
        $this->dateCreation = $InDateCreation;
        $this->idPost = $InIdPost;


    }

    public $id;
    public $nom;
    public $type;
    public $dateCreation;
    public $idPost;

}

/**
 * Fonction qui récupère les messages 
 * 
 * @return EMedia $c
 */
function getAllMedia()
{
    $tabBlog = array();
    $sql = "SELECT MEDIA.idMedia, MEDIA.nomMedia, MEDIA.typeMedia, MEDIA.creationDate, MEDIA.idPost
    FROM MEDIA";
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
        $tabBlog[] = new EMedia($row['idMedia'], $row['nomMedia'],$row['typeMedia'], $row['creationDate'], $row['idPost']);
        // On place l'objet EClient créé dans le tableau
    }
    // Done
    return $tabBlog;
}