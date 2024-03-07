// On ajoute une call-back qui sera appelée une fois le document 
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
        formData.append('image', imgFile.files[0]);

        // Make a fetch request
        imgFile.style.borderColor = "";

        // On cache les erreurs précédentes, s'il y en a eu

        // Lancer la requête ajax
        makeRequest(message.value, formData);

    }//#end validateLogin

    /**
     * Exécuter la requête ajax pour valider l'utilisateur et son mot de passe
     *
     * @param string username   L'email de l'utilisateur
     * @param string pswd       Le mot de passe associé
     */
    function makeRequest(message, formData) {
        var jsonObj = {};
        jsonObj.message = message;
        jsonObj.formData = formData;
        let searchParams = new URLSearchParams(jsonObj);

        fetch('http://localhost/M152/?page=post', {
            method: 'POST', // or GET
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: searchParams.toString()
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
                        document.getElementById("errorParam").style.display = "block";
                        break;
                    case 2: // User et/ou mot de passe invalide
                        document.getElementById("errorLogin").style.display = "block";
                        break;
                }
            })
            .catch((error) => {
                // console.log(response + data);

                console.error('Error:' + error);
            });
    }//#end makeRequest
}