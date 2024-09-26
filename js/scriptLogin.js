function mailMdp(){  // Fonction changer mdp
  // Recuperation des donnees 
  var email = $("#emailMdp").val();

  // Prépare les données pour l'envoi à la page PHP sous forme d'objet JavaScript
  var donnee = {
      emailMdp: email,
  };
  $('#rep_emailMdp').empty();  // clear la div reponse
  $('#rep_emailMdp').removeClass()  // Enleve toute les classe
  $('#emailMdp').removeClass('input_erreur');
  // Envoi de la requête AJAX avec jQuery
  $.ajax({
      type: "POST", // Méthode HTTP POST
      url: "verifUser.php", // URL de la page PHP de traitement
      data: donnee, // Données à envoyer
      dataType: "json", // Type de données attendu en réponse (HTML dans ce cas)

      success: function(response) {
          // Fonction appelée en cas de succès
          if(response['erreur'] == 0){
            $("#rep_emailMdp").addClass("alert-rouge");
            $("#rep_emailMdp").html("Veuillez mettre une adresse mail.");
            $('#emailMdp').addClass('input_erreur');
          }
          else if(response['erreur'] == -10){
            $("#rep_emailMdp").addClass("alert-vert");
            $("#rep_emailMdp").html("Un email de récupération à été envoyé à cette adresse si elle existe.");
          }
          else if(response['erreur'] == -11){
            $("#rep_emailMdp").addClass("alert-orange");
            $("#rep_emailMdp").html("Une demande à déjà été envoyé à cette adresse. Veuillez attendre au moins 10 minutes.");
          }
          else{
            $("#rep_emailMdp").html("Veuillez attendre : "+ response['temps'] +" secondes");
            $("#rep_emailMdp").addClass("alert-orange");
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

function connex(){  // Fonction connexion
  // On retire la classe de clignottement d'input erreur dans chaque input
  $('input').removeClass('input_erreur');

  var email = $("#emailc").val();
  var mdp = $("#mdp").val();

  // Prépare les données pour l'envoi à la page PHP sous forme d'objet JavaScript
  var donnee = {
    emailc : email,
    mdp : mdp,
  };
  // Envoi de la requête AJAX avec jQuery
  $.ajax({
    type: "POST", // Méthode HTTP POST
    url: "verifUser.php", // URL de la page PHP de traitement
    data: donnee, // Données à envoyer
    dataType: "json", // Type de données attendu en réponse

    success: function(response) {
        $('#rep_connexion').empty();  // clear la div reponse
        $('#rep_connexion').removeClass()  // Enleve toute les classe
        if(response['email'] != undefined && response['mdp'] != undefined){
          if(response['email'] == 0){
            $("#rep_connexion").html("Veuillez remplir les champs en surbrillance");
            $("#rep_connexion").addClass("alert-rouge");
            $('#emailc').addClass('input_erreur');
          }
          if(response['mdp'] == 0){
            $("#rep_connexion").html("Veuillez remplir les champs en surbrillance");
            $("#rep_connexion").addClass("alert-rouge");
            $('#mdp').addClass('input_erreur');
          }
        }
        else if(response['temps'] != undefined){
          if(response['temps'] == "non"){
            $("#rep_connexion").html("Les identifiants sont incorrects<br>Veuillez réessayer");
            $("#rep_connexion").addClass("alert-rouge");
          }
          else{
            $("#rep_connexion").html("Veuillez attendre : "+ response['temps'] +" secondes");
            $("#rep_connexion").addClass("alert-orange");
          }
        }
        else if(response['connecte'] != undefined){
          if(response['connecte'] == 1){
            window.location.href = "../index.php";
          }
        };
        console.log(response);


    },

    error: function(xhr, status, error) {
        // Fonction appelée en cas d'erreur
        console.error("Erreur: " + error);
        console.error("Status: " + status);
    }
  });

}

function inscript(){  // Fonction inscription
    // On retire la classe de clignottement d'input erreur dans chaque input
    $('input').removeClass('input_erreur');
    
    // Recuperation des donnees 
    var prenom = $("#prenom").val();
    var nom = $("#nom").val();
    var email = $("#email").val();
    var tel = $("#tel").val();
    var dateNaiss = $("#dateNaiss").val();
    var mdp1 = $("#mdp1").val();
    var mdp2 = $("#mdp2").val();

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
    // Envoi de la requête AJAX avec jQuer y
    $.ajax({
        type: "POST", // Méthode HTTP POST
        url: "verifUser.php", // URL de la page PHP de traitement
        data: donnee, // Données à envoyer
        dataType: "json", // Type de données attendu en réponse (HTML dans ce cas)

        success: function(response) {
          
            $('#rep_inscription').empty();  // clear la div reponse
            $('#rep_inscription').removeClass()  // Enleve toute les class
            // Fonction appelée en cas de succès de l'envoi de la requete
            var error = -999;

            $.each(response, function(cle, val){
              if(val == 0){
                $("#rep_inscription").html("Veuillez remplir les champs en surbrillance");
                $("#rep_inscription").addClass("alert-rouge");
                error = 0;  // erreur de type 0, cad champs non rempli
                switch (cle) {
                  case 'prenom':
                    $('#prenom').addClass('input_erreur');
                    break;
                  case 'nom':
                    $('#nom').addClass('input_erreur');
                    break;
                  case 'email':
                    $('#email').addClass('input_erreur');
                    break;
                  case 'telephone':
                    $('#tel').addClass('input_erreur');
                    break;
                  case 'dateNaissance':
                    $('#dateNaiss').addClass('input_erreur');
                    break;
                  case 'mdp':
                    $('#mdp1').addClass('input_erreur');
                    $('#mdp2').addClass('input_erreur');
                    break;
                  default:
                    break;
                }
              }
            });
            if(error == -999){
              $.each(response, function(cle, val){
                if(val == -1){
                  $("#rep_inscription").html("Les champs en surbrillance sont invalide");
                  $("#rep_inscription").addClass("alert-rouge");
                  error = -1;  // erreur de type -1, cad champs invalide
                  switch (cle) {
                    case 'prenom':
                      $('#prenom').addClass('input_erreur');
                      break;
                    case 'nom':
                      $('#nom').addClass('input_erreur');
                      break;
                    case 'email':
                      $('#email').addClass('input_erreur');
                      break;
                    case 'telephone':
                      $('#tel').addClass('input_erreur');
                      break;
                    case 'dateNaissance':
                      $('#dateNaiss').addClass('input_erreur');
                      break;
                    default:
                      break;
                  }
                }
              });
            }
            if(error == -999){
              // Erreur champ mdp vide :
              if(response['mdp'] == -2){
                $("#rep_inscription").append("Veuillez vérifier votre mot de passe");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp2').addClass('input_erreur');
                error = -2;
              }
              if(response['mdp'] == -4){
                $("#rep_inscription").append("Veuillez inscrire un mot de passe");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -4;
              }
              // erreur mdp different
              if(response['mdp'] == -3){
                $("#rep_inscription").append("Les mots de passe sont différents");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                $('#mdp2').addClass('input_erreur');
                error = -3;
              }
              if(response['mdp'] == -4){
                $("#rep_inscription").append("Veuillez inscrire un mot de passe");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -4;
              }
              if(response['mdp'] == -5){  // - 7 caractères
                $("#rep_inscription").append("Le mot de passe est trop court");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -5;
              }
              if(response['mdp'] == -6){  // Pas de chiffre
                $("#rep_inscription").append("Le mot de passe doit contenir 1 chiffre");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -6;
              }
              if(response['mdp'] == -7){  // Pas de maj
                $("#rep_inscription").append("Le mot de passe doit contenir une majuscule");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -7;
              }
              if(response['mdp'] == -8){  // Pas de minuscule
                $("#rep_inscription").append("Le mot de passe doit contenir une majuscule");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -8;
              }
              if(response['mdp'] == -9){
                $("#rep_inscription").append("Le mot de passe doit contenir un caractère spécial");
                $("#rep_inscription").addClass("alert-rouge");
                $('#mdp1').addClass('input_erreur');
                error = -9;
              }
              // Erreur mail deja existant
              if(response['email'] == -10){
                $("#rep_inscription").append("Il existe déjà un compte avec cet email");
                $("#rep_inscription").addClass("alert-orange");
                $('#email').addClass('input_erreur');
                error = -10;
              }    
            }// S'il y a aucune erreur
            if(error == -999){
              $("#rep_inscription").html("Bienvenue parmi nous dresseur Pokemon !");
              $("#rep_inscription").addClass("alert-vert");
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

function toggleSignup(){
	document.getElementById("login-toggle").style.backgroundColor="#fff";
  document.getElementById("login-toggle").style.color="#222";
  document.getElementById("signup-toggle").style.backgroundColor="#ee1515";
  document.getElementById("signup-toggle").style.color="#fff";
  document.getElementById("login-form").style.display="none";
  document.getElementById("signup-form").style.display="block";
  document.getElementById("mdp-form").style.display="none";
}

function toggleMdp(){
	document.getElementById("login-toggle").style.backgroundColor="#fff";
  document.getElementById("login-toggle").style.color="#222";
  document.getElementById("signup-toggle").style.backgroundColor="#fff";
  document.getElementById("signup-toggle").style.color="#222";
  document.getElementById("login-form").style.display="none";
  document.getElementById("signup-form").style.display="none";
  document.getElementById("mdp-form").style.display="block";
}

function toggleLogin(){
  document.getElementById("login-toggle").style.backgroundColor="#ee1515";
  document.getElementById("login-toggle").style.color="#fff";
  document.getElementById("signup-toggle").style.backgroundColor="#fff";
  document.getElementById("signup-toggle").style.color="#222";
  document.getElementById("signup-form").style.display="none";
  document.getElementById("login-form").style.display="block";
  document.getElementById("mdp-form").style.display="none";
}

// Fonction pour créer un nouveau mdp (mdp perdue)
function changeNewMdp(){
  // Recuperation des donnees 
  var mdp1 = $("#mdp1").val();
  var mdp2 = $("#mdp2").val();
  // Récupération de l'URL actuelle
  var urlParams = new URLSearchParams(window.location.search);
  var token = urlParams.get('token');
  // Prépare les données pour l'envoi à la page PHP sous forme d'objet JavaScript
  var donnee = {
      mdp1:mdp1,
      mdp2:mdp2,
      token:token,
  };
  $('#rep_newMdp').empty();  // clear la div reponse
  $('#rep_newMdp').removeClass()  // Enleve toute les classe
  $('#mdp1').removeClass('input_erreur');
  $('#mdp2').removeClass('input_erreur');

  // Envoi de la requête AJAX avec jQuery
  $.ajax({
      type: "POST", // Méthode HTTP POST
      url: "verifNewMdp.php", // URL de la page PHP de traitement
      data: donnee, // Données à envoyer
      dataType: "json", // Type de données attendu en réponse (HTML dans ce cas)

      success: function(response) {
          // Fonction appelée en cas de succès
          if(response['erreur'] == 1){
            $("#rep_newMdp").addClass("alert-vert");
            $("#rep_newMdp").html("Le mot de passe a été modifié.");
          }
          else if(response['erreur'] == -999){
            $("#rep_newMdp").addClass("alert-rouge");
            $("#rep_newMdp").html("Erreur de serveur.");
          }
          else if(response['erreur'] == 0){
            $("#rep_newMdp").addClass("alert-rouge");
            $("#rep_newMdp").html("Veuillez inscrire votre nouveau mot de passe.");
            $('#mdp1').addClass('input_erreur');
          }
          else if(response['erreur'] == -1){
            $("#rep_newMdp").addClass("alert-rouge");
            $("#rep_newMdp").html("Veuillez vérifier votre nouveau mot de passe.");
            $('#mdp2').addClass('input_erreur');
          }
          else if(response['erreur'] == -2){
            $("#rep_newMdp").addClass("alert-rouge");
            $("#rep_newMdp").html("Les mots de passe ne correspondent pas.");
          }
          else if(response['erreur'] == -3){
            $("#rep_newMdp").addClass("alert-rouge");
            $("#rep_newMdp").html("Veuillez remplir les champs en surbrillance.");
            $('#mdp1').addClass('input_erreur');
            $('#mdp2').addClass('input_erreur');
          }
          else if(response['erreur'] == -4){
            $("#rep_newMdp").addClass("alert-orange");
            $("#rep_newMdp").html("Le lien vient d'être utilisé.");
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
    var bouton = $("#boutonMdp");
    if (x.type === "password") {
      x.type = "text";
      bouton.removeClass("fa-eye-slash");
      bouton.addClass("fa-eye");
    } else {
      x.type = "password";
      bouton.removeClass("fa-eye");
      bouton.addClass("fa-eye-slash");
    }
}
function voirMDP1() {
    var x = document.getElementById("mdp1");
    var bouton = $("#boutonMdp1");
    if (x.type === "password") {
      x.type = "text";
      bouton.removeClass("fa-eye-slash");
      bouton.addClass("fa-eye");
    } else {
      x.type = "password";
      bouton.removeClass("fa-eye");
      bouton.addClass("fa-eye-slash");
    }
}
function voirMDP2() {
    var x = document.getElementById("mdp2");
    var bouton = $("#boutonMdp2");
    if (x.type === "password") {
      x.type = "text";
      bouton.removeClass("fa-eye-slash");
      bouton.addClass("fa-eye");
    } else {
      x.type = "password";
      bouton.removeClass("fa-eye");
      bouton.addClass("fa-eye-slash");
    }
}
//////////////////////////////////////////////////////////