/*
* Nom : post.js
* Auteur : Sam Freddi 
* Date : 06.09.2023
* Version : 1.0
*/

// complètement chargé par le navigateur
window.addEventListener('load', (event) => {
    // On ajoute une call-back sur le click du bouton Login


});


function postImage() {
    console.log("post");

    // On va vérifier que les champs sont remplis
    var message = document.getElementById("message");
    var imgFile = document.getElementById("img");
    var formData = new FormData();

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


    if (imgFile.files.length > 0) {
        for (let index = 0; index < imgFile.files.length; index++) {
            formData.append('img', imgFile.files[index]);

        }

    }
    // Make a fetch request
    imgFile.style.borderColor = "";

    // On cache les erreurs précédentes, s'il y en a eu

    // Lancer la requête ajax
    formData.append("message", message.value);
    makeRequestPost(message.value, formData);

}//#end validateLogin

/**
 * Exécuter la requête ajax pour valider l'utilisateur et son mot de passe
 *
 * @param string username   L'email de l'utilisateur
 * @param string pswd       Le mot de passe associé
 */
function makeRequestPost(message, formData) {
    var jsonObj = {};
    jsonObj.message = message;
    jsonObj.formData = formData;
    let searchParams = new URLSearchParams(jsonObj);

    fetch('http://localhost/M152/?page=post', {
        method: 'POST',

        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            switch (data.ReturnCode) {
                case 0: // C'est tout bon
                    console.log("ici");
                    window.location = "http://localhost/M152/?page=home";
                    break;
                case 1: // Paramètres invalides
                    // On affiche le message d'erreur

                    break;
                case 2: // User et/ou mot de passe invalide

                    break;
            }
        })
        .catch((error) => {
            // console.log(response + data);

            console.error('Error:' + error);
        });
}//#end makeRequest
