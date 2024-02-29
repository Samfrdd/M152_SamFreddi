// On ajoute une call-back qui sera appelée une fois le document 
// complètement chargé par le navigateur
window.addEventListener('load', (event) => {
    // On ajoute une call-back sur le click du bouton Login


});


function postImage() {
    console.log("post");

    // On va vérifier que les champs sont remplis
    var message = document.getElementById("message");
    var img = document.getElementById("img");

    if (message.value.length == 0) {
        // On met par exemple le broder en rouge
        message.style.borderColor = "red";
        // Mettre le focus sur le champ mot de passe
        message.focus();
        // Fail, pas la peine de continuer
        return;
    }
    else {
        message.style.borderColor = "";
    }



    img.style.borderColor = "";

    // On cache les erreurs précédentes, s'il y en a eu

    // Lancer la requête ajax
    makeRequest(message.value, img.value);

}//#end validateLogin


/**
 * Exécuter la requête ajax pour valider l'utilisateur et son mot de passe
 *
 * @param string username   L'email de l'utilisateur
 * @param string pswd       Le mot de passe associé
 */
function makeRequest(message, img) {
    var jsonObj = {};
    jsonObj.message = message;
    jsonObj.img = img;
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
            console.log(response + data);
            window.location = "./controller/c_controller.php?page=home";
            switch (data.ReturnCode) {
                case 0: // C'est tout bon
                    console.log("ici");
                    window.location = "./controller/controller.php?page=home";
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
            console.error('Error:' + error);
        });
}//#end makeRequest
