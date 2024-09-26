from django.db import models

class Utilisateur(models.Model):
    prenom = models.CharField(max_length=150)  # Réduction à 150 caractères
    nom = models.CharField(max_length=150)  # Réduction à 150 caractères
    email = models.EmailField(unique=True, max_length=150)  # Réduction à 150 caractères
    telephone = models.CharField(max_length=15)
    date_naissance = models.DateField()
    mdp = models.CharField(max_length=150)  # Réduction à 150 caractères
    statut = models.CharField(max_length=50)  # 'admin' ou 'client'

    def __str__(self):
        return f"{self.prenom} {self.nom}"

class Commande(models.Model):
    utilisateur = models.ForeignKey(Utilisateur, on_delete=models.CASCADE)
    adresse_livraison = models.CharField(max_length=150)  # Réduction à 150 caractères
    ville = models.CharField(max_length=150)  # Réduction à 150 caractères
    code_postal = models.IntegerField()
    livraison = models.CharField(max_length=150)
    total = models.DecimalField(max_digits=7, decimal_places=2)
    numero_commande = models.CharField(max_length=100, db_index=False)  # Désactiver l'indexation automatique
    date_creation = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"Commande {self.numero_commande} de {self.utilisateur.prenom}"
