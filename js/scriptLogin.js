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

function connex() {
  $('input').removeClass('input_erreur');

  var email = $("#emailc").val();
  var mdp = $("#mdp").val();

  if (email === '' || mdp === '') {
      $("#rep_connexion").html("Veuillez remplir tous les champs");
      $("#rep_connexion").addClass("alert-rouge");
      return false;
  }

  var donnee = {
      email: email,
      password: mdp
  };

  // Envoi de la requête pour obtenir les tokens et l'ID utilisateur
  $.ajax({
      type: "POST",
      url: "http://127.0.0.1:8000/api/auth/login/",
      data: JSON.stringify(donnee),
      contentType: "application/json",
      dataType: "json",

      success: function(response) {
          if (response.access && response.refresh && response.user_id) {
              // Stocker les tokens dans localStorage
              localStorage.setItem('access_token', response.access);
              localStorage.setItem('refresh_token', response.refresh);

              // Utilisation de l'ID utilisateur pour récupérer ses informations
              $.ajax({
                  type: "GET",
                  url: "http://127.0.0.1:8000/api/utilisateurs/" + response.user_id + "/",  // Utilisation de l'ID utilisateur retourné
                  headers: {
                      'Authorization': 'Bearer ' + response.access  // Utilisation du token d'accès
                  },
                  success: function(userInfo) {
                      // Envoi des informations utilisateur à setSession.php pour les stocker en session PHP
                      $.ajax({
                          type: "POST",
                          url: "setSession.php",
                          data: {
                              prenom: userInfo.prenom,
                              nom: userInfo.nom,
                              email: userInfo.email,
                              statut: userInfo.statut,  // Statut de l'utilisateur
                              access_token: response.access,  // On envoie l'access token
                              user_id: response.user_id       // On envoie aussi l'ID utilisateur
                          },
                          success: function() {
                              window.location.href = "../index.php"; // Redirection après connexion
                          },
                          error: function() {
                              $("#rep_connexion").html("Erreur lors de la connexion.");
                              $("#rep_connexion").addClass("alert-rouge");
                          }
                      });
                  },
                  error: function() {
                      $("#rep_connexion").html("Erreur lors de la récupération des informations.");
                      $("#rep_connexion").addClass("alert-rouge");
                  }
              });
          } else {
              $("#rep_connexion").html("Erreur lors de la connexion");
              $("#rep_connexion").addClass("alert-rouge");
          }
      },

      error: function(xhr, status, error) {
          if (xhr.status == 401) {
              $("#rep_connexion").html("Email ou mot de passe incorrect");
              $("#rep_connexion").addClass("alert-rouge");
          } else {
              $("#rep_connexion").html("Erreur lors de la connexion");
              $("#rep_connexion").addClass("alert-rouge");
          }
      }
  });

  return false;
}


function inscript() {
  console.log("La fonction inscript() est appelée");

  // Récupération des données depuis les champs du formulaire
  var prenom = $("#prenom").val();
  var nom = $("#nom").val();
  var email = $("#email").val();
  var password = $("#mdp1").val();

  // Vérification des champs vides pour afficher une erreur s'ils ne sont pas remplis
  if (prenom === '' || nom === '' || email === '' || password === '') {
      $("#rep_inscription").html("Veuillez remplir tous les champs.");
      $("#rep_inscription").addClass("alert-rouge");
      return;
  }

  // Préparation des données pour l'envoi à l'API
  var donnee = {
      prenom: prenom,
      nom: nom,
      email: email,
      password: password
  };

  console.log("Données préparées pour l'envoi : ", donnee);

  // Envoi de la requête AJAX avec jQuery
  $.ajax({
      type: "POST", // Méthode HTTP POST
      url: "http://127.0.0.1:8000/api/inscription/", // URL de l'API d'inscription
      data: JSON.stringify(donnee), // Convertir les données en JSON pour l'envoi
      contentType: "application/json", // Spécifier que les données sont en JSON
      dataType: "json", // Type de données attendu en réponse (JSON)

      beforeSend: function() {
          console.log("Envoi de la requête AJAX...");
      },

      success: function(response) {
          console.log("Réponse reçue : ", response);
          $('#rep_inscription').empty();  
          $('#rep_inscription').removeClass();

          // Logique de succès : Afficher un message de bienvenue
          $("#rep_inscription").html("Bienvenue parmi nous, dresseur Pokemon !");
          $("#rep_inscription").addClass("alert-vert");
      },

      error: function(xhr, status, error) {
          console.error("Erreur AJAX: " + error);
          console.error("Status: " + status);
          console.error("Réponse serveur : ", xhr.responseText);

          // Affichage des erreurs à l'utilisateur
          if (xhr.status === 400) {
              $("#rep_inscription").html("Erreur lors de l'inscription. Veuillez vérifier les informations fournies.");
              $("#rep_inscription").addClass("alert-rouge");
          } else if (xhr.status === 500) {
              $("#rep_inscription").html("Erreur interne du serveur. Veuillez réessayer plus tard.");
              $("#rep_inscription").addClass("alert-rouge");
          } else {
              $("#rep_inscription").html("Erreur inattendue. Veuillez réessayer.");
              $("#rep_inscription").addClass("alert-rouge");
          }
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