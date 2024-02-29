// On ajoute une call-back qui sera appelée une fois le document 
// complètement chargé par le navigateur
window.addEventListener('load', (event) => {
    // On ajoute une call-back sur le click du bouton Login
    const el = document.getElementById("send");
    el.addEventListener('click', validateLogin, false);
});



/**
* On va valider les données du formulaire de saisie
* et faire un appel ajax pour valider l'authentification
*/
function validateLogin(event) {


    // On va vérifier que les champs sont remplis
    var user = document.getElementById("username");
    var pswd = document.getElementById("pswd");

    if (user.value.length == 0) {
        // On met par exemple le broder en rouge
        user.style.borderColor = "red";
        // Mettre le focus sur le champ mot de passe
        user.focus();
        // Fail, pas la peine de continuer
        return;
    }
    else
        user.style.borderColor = "";

    if (pswd.value.length == 0) {
        pswd.style.borderColor = "red";
        pswd.focus();
        return;
    }
    else
        pswd.style.borderColor = "";

    // On cache les erreurs précédentes, s'il y en a eu
   
    // Lancer la requête ajax
    makeRequest(user.value, pswd.value);

}//#end validateLogin


/**
 * Exécuter la requête ajax pour valider l'utilisateur et son mot de passe
 *
 * @param string username   L'email de l'utilisateur
 * @param string pswd       Le mot de passe associé
 */
function makeRequest(username, pswd) {
    var jsonObj = {};
    jsonObj.username = username;
    jsonObj.password = pswd;
    let searchParams = new URLSearchParams(jsonObj);

    fetch('test.php', {
        method: 'POST', // or GET
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: searchParams.toString()
    })
        .then(response => response.json())
        .then(data => {
            switch (data.ReturnCode) {
                case 0: // C'est tout bon
                    console.log("go")
                    break;
                case 1: // Paramètres invalides
                    // On affiche le message d'erreur
                    document.getElementById("errorParam").style.display = "block";
                    break;
                case 2: // User et/ou mot de passe invalide
                    document.getElementById("errorLogin").style.display = "block";
                    break;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}//#end makeRequest
