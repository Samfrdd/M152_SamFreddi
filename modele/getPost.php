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
