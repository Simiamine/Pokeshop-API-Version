from django.db import models
from django.core.exceptions import ValidationError
from django.utils import timezone

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
    
    class Meta:
        db_table = 'utilisateur'  # Correspond à ta table existante
        managed = False

class Commande(models.Model):
    STATUT_CHOICES = [
        ('EN_TRAITEMENT', 'En traitement'),
        ('EXPEDIEE', 'Expédiée'),
        ('LIVREE', 'Livrée'),
        ('ANNULEE', 'Annulée'),
    ]

    STATUT_LIVRAISON_CHOICES = [
        ('EN_ATTENTE', 'En attente'),
        ('EN_COURS', 'En cours'),
        ('LIVREE', 'Livrée'),
        ('ECHOUÉE', 'Échouée')
    ]

    utilisateur = models.ForeignKey(Utilisateur, on_delete=models.CASCADE)
    adresse_livraison = models.CharField(max_length=150)  # Réduction à 150 caractères
    ville = models.CharField(max_length=150)  # Réduction à 150 caractères
    code_postal = models.IntegerField()
    livraison = models.CharField(max_length=150)  # Transporteur ou mode de livraison
    total = models.DecimalField(max_digits=7, decimal_places=2)
    numero_commande = models.CharField(max_length=100, db_index=False)  # Désactiver l'indexation automatique
    date_creation = models.DateTimeField(auto_now_add=True)
    statut = models.CharField(max_length=20, choices=STATUT_CHOICES, default='EN_TRAITEMENT')
    statut_livraison = models.CharField(max_length=20, choices=STATUT_LIVRAISON_CHOICES, default='EN_ATTENTE')  # Ajouté pour la gestion des livraisons

    def __str__(self):
        return f"Commande {self.numero_commande} de {self.utilisateur.prenom}"

    class Meta:
        db_table = 'commandes'  # Correspond à ta table existante
        managed = False
    
    

class Pokedex(models.Model):
    id = models.IntegerField(primary_key=True)
    nom = models.CharField(max_length=100)
    type_1 = models.CharField(max_length=100)
    type_2 = models.CharField(max_length=100, null=True, blank=True)
    generation = models.IntegerField()
    legendaire = models.BooleanField(default=False)
    prix = models.DecimalField(max_digits=5, decimal_places=2)
    discount = models.IntegerField()
    image = models.CharField(max_length=150)
    quantite = models.IntegerField(default=0)
    description = models.CharField(max_length=250)

    class Meta:
        db_table = 'pokedex'  # Correspond à la table existante 'pokedex'
        managed = False

    def save(self, *args, **kwargs):
    # Vérifie uniquement lors de la création
        if self.pk is None and Pokedex.objects.filter(id=self.id).exists():
            raise ValidationError(f"Un Pokémon avec l'ID {self.id} existe déjà.")
        super(Pokedex, self).save(*args, **kwargs)

    def __str__(self):
        return self.nom

class Paiement(models.Model):
    STATUT_CHOICES = [
        ('en_attente', 'En attente'),
        ('valide', 'Validé'),
        ('echoue', 'Échoué'),
    ]

    transaction_id = models.CharField(max_length=100, unique=True)
    commande = models.ForeignKey(Commande, on_delete=models.CASCADE)
    montant = models.DecimalField(max_digits=10, decimal_places=2)
    statut = models.CharField(max_length=10, choices=STATUT_CHOICES, default='en_attente')
    date_creation = models.DateTimeField(default=timezone.now)
    
    class Meta:
        db_table = 'paiement'  # Correspond à la table existante 'paiement'
        managed = False

    def __str__(self):
        return f"Paiement {self.transaction_id} - Statut : {self.statut}"
