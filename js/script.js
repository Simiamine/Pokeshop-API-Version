

function inscript(){  // Fonction inscription
    // Recuperation des donnees 
    var prenom = $(".inscription input[name='prenom']").val();
    var nom = $(".inscription input[name='nom']").val();
    var email = $(".inscription input[name='email']").val();
    var tel = $(".inscription input[name='telephone']").val();
    var dateNaiss = $(".inscription input[name='dateNaiss']").val();
    var mdp1 = $(".inscription input[name='mdp1']").val();
    var mdp2 = $(".inscription input[name='mdp2']").val();

    // Formater la date en format français
    if(dateNaiss != ""){
        var dateObj = new Date(dateNaiss);
        var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
        var dateNaiss = dateObj.toLocaleDateString('fr-FR', options);
    }
    // Prépare les données pour l'envoi à la page PHP sous forme d'objet JavaScript
    var donnee = {
        prenom : prenom,
        nom : nom,
        email : email,
        tel : tel,
        dateNaiss : dateNaiss,
        mdp1 : mdp1,
        mdp2 : mdp2,
    };
    console.log(donnee);
    
    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        type: "POST", // Méthode HTTP POST
        url: "verifUser.php", // URL de la page PHP de traitement
        data: donnee, // Données à envoyer
        //dataType: "json", // Type de données attendu en réponse (HTML dans ce cas)

        success: function(response) {
            $('#rep_inscription').empty();  // clear la div reponse
            // Fonction appelée en cas de succès de l'envoi de la requete
            var compteur = 0;
            $.each(response, function(cle, val){
                if(val !== 1 ){
                    compteur ++;
                    $("#rep_inscription").append("Je vais mettre les codes d'erreurs ici.<br> Si ce message s'affiche, c'est que l'inscription des données dans la bdd n'a pas fonctionné psk y'a des erreurs dans les champs. <br>");
                }
        
            });
            if(compteur == 0){
                $("#rep_inscription").append("Les données ont bien étées inscrites dans la bdd <br>");
            }
            console.log(response);
        },

        error: function(xhr, status, error) {
            // Fonction appelée en cas d'erreur
            console.error("Erreur: " + error);
            console.error("Status: " + status);
        }
    });
}



/////// Fonction pour voir le mdp ///////////////////////
function voirMDP() {
    var x = document.getElementById("mdp");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}
function voirMDP1() {
    var x = document.getElementById("mdp1");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}
function voirMDP2() {
    var x = document.getElementById("mdp2");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}
//////////////////////////////////////////////////////////