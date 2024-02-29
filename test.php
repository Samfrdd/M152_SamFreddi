<?php
//Initialisation des variables
$user = "";
$pswd = "";

// récupère les données du post
// finalement, identique à votre code php dans la version Web1
if (filter_has_var(INPUT_POST, "username"))
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
if (filter_has_var(INPUT_POST, "password"))
    $pswd = $_POST["password"];

// On vérifie qu'on a bien des données
if (strlen($user) > 0 && strlen($pswd) > 0) {
    // Vérifier les données de login saisies
    if ($user && $pswd) {
        // On rend la réponse sous forme JSON
        echo '{ "ReturnCode": 0, "Message": "Nom et mot de passe correspondent."}';
        // Attention de bien mettre exit
        // autrement vous risquez d'avoir de l'output qui s'ajoute dans le stream de retour
        // et votre réponse JSON ne sera pas valide
        exit();
    } else {
        // On rend la réponse sous forme JSON
        echo '{ "ReturnCode": 2, "Message": "Nom et/ou mot de passe invalide."}';
        exit();
    }
}

// Problème
echo '{ "ReturnCode": 1, "Message": "Paramètres manquants ou invalides."}';




?>

<form action="#" method="POST">
    <span>Nom d'utilisateur: </span><input type="text" id="username"></input>
    <br>
    <span>Mot de passe: </span><input type="password" id="pswd"></input>
    <input type="button" id="send" value="Login"></input>
</form>


<script src="./test.js"></script>