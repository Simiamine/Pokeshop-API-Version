Pokeshop API

Pokeshop API est un projet développé avec Django, qui permet la gestion d'une boutique en ligne fictive avec des produits, des utilisateurs, des commandes, des paiements via Stripe, et un système de gestion des avis des utilisateurs. Ce projet utilise JWT (JSON Web Tokens) pour l'authentification.

Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :
- Python 3.8+
- pip
- MySQL (ou tout autre serveur de base de données relationnelle compatible avec Django)
- Stripe Account pour les paiements
- Un client HTTP comme Postman ou cURL

Installation

1. Cloner le projet

git clone https://github.com/Simiamine/Pokeshop-API-Version.git
cd pokeshop-api

2. Créer et activer un environnement virtuel

Il est recommandé d'utiliser un environnement virtuel pour isoler les dépendances du projet.

# Créer un environnement virtuel
python -m venv env

# Activer l'environnement (sur MacOS/Linux)
source env/bin/activate

# Sur Windows
.\env\Scripts\activate

3. Installer les dépendances du projet

pip install -r requirements.txt

4. Configurer la base de données

- Assurez-vous d'avoir MySQL installé et d'avoir une base de données configurée.
- Mettez à jour votre fichier settings.py pour inclure vos informations de connexion MySQL.

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': 'pokemon',  
        'USER': 'root',  
        'PASSWORD': 'votre-mot-de-passe',  
        'HOST': 'localhost',
        'PORT': '3306',
    }
}

- Appliquez les migrations SQL à votre base de données (ou configurez manuellement les tables si vous ne souhaitez pas utiliser makemigrations).

python manage.py migrate

5. Configurer Stripe

Créez un compte Stripe si ce n’est pas encore fait, et récupérez vos clés d'API (STRIPE_SECRET_KEY, STRIPE_PUBLIC_KEY, et STRIPE_WEBHOOK_SECRET).

Ajoutez ces informations dans votre fichier .env à la racine du projet :

STRIPE_SECRET_KEY=sk_test_your_secret_key
STRIPE_PUBLIC_KEY=pk_test_your_public_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

6. Créer un super utilisateur pour accéder à l'administration Django

python manage.py createsuperuser

Suivez les instructions pour créer un administrateur.

7. Lancer le serveur

python manage.py runserver

Votre API sera maintenant disponible à l'adresse suivante : http://127.0.0.1:8000/

Fonctionnalités de l'API

L'API expose plusieurs fonctionnalités pour gérer les utilisateurs, produits, commandes, paiements, et avis des utilisateurs.

Requêtes disponibles

Authentification

Connexion (Login) :
URL : /auth/login/
Méthode : POST
Body :
{
    "email": "user@example.com",
    "password": "your_password"
}
Réponse :
{
    "refresh": "your_refresh_token",
    "access": "your_access_token",
    "message": "Connexion réussie"
}

Rafraîchir le Token JWT :
URL : /auth/token/refresh/
Méthode : POST
Body :
{
    "refresh": "your_refresh_token"
}

Utilisateurs

Créer un utilisateur (Inscription) :
URL : /inscription/
Méthode : POST
Body :
{
    "prenom": "John",
    "nom": "Doe",
    "email": "john@example.com",
    "telephone": "1234567890",
    "date_naissance": "1990-01-01",
    "mdp": "your_password",
    "statut": "client"
}

Modifier un utilisateur :
URL : /utilisateurs/<int:pk>/modifier/
Méthode : PUT ou PATCH

Supprimer un utilisateur :
URL : /utilisateurs/<int:pk>/supprimer/
Méthode : DELETE

Produits (Pokedex)

Lister les produits disponibles :
URL : /pokedex/
Méthode : GET

Vérifier les niveaux de stock :
URL : /pokedex/stock/
Méthode : GET

Commandes

Créer une commande :
URL : /commandes/
Méthode : POST
Body :
{
    "utilisateur": 1,
    "adresse_livraison": "123 Main St",
    "ville": "Paris",
    "code_postal": "75001",
    "livraison": "Colissimo",
    "total": "100.00",
    "produits": [1, 2, 3]
}

Suivi de livraison :
URL : /commandes/<int:pk>/suivi-livraison/
Méthode : GET

Mettre à jour les informations de livraison :
URL : /commandes/<int:pk>/update-livraison/
Méthode : PUT ou PATCH

Paiements (via Stripe)

Créer un paiement :
URL : /paiements/traiter/
Méthode : POST
Body :
{
    "commande_id": 1,
    "montant": 100.00
}

Suivre le statut d'un paiement :
URL : /paiements/statut/<str:transaction_id>/
Méthode : GET

Avis

Lister les avis d'un produit :
URL : /produits/<int:pk>/avis/
Méthode : GET

Ajouter un avis pour un produit :
URL : /produits/<int:pk>/ajouter-avis/
Méthode : POST
Body :
{
    "note": 5,
    "commentaire": "Super produit !"
}

Supprimer un avis (réservé aux administrateurs) :
URL : /avis/<int:pk>/supprimer-avis/
Méthode : DELETE

Authentification

L'API utilise JWT pour l'authentification. Après s'être connecté via /auth/login/, les utilisateurs doivent inclure leur token JWT dans les en-têtes de leurs requêtes protégées :

Authorization: Bearer <token>

Les tokens d'accès JWT ont une durée de vie limitée (1 heure). Vous pouvez les rafraîchir avec le token de rafraîchissement via /auth/token/refresh/.

Webhooks

Stripe envoie des webhooks pour informer votre serveur des changements de statut des paiements. Le webhook Stripe est accessible via :

URL : /webhook/
Méthode : POST

Assurez-vous d'ajouter cet URL dans votre Dashboard Stripe pour recevoir les événements.