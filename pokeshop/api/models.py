from django.db import models
from django.core.exceptions import ValidationError
from django.utils import timezone
from django.contrib.auth.hashers import make_password
from django.contrib.auth.models import AbstractBaseUser, BaseUserManager



class UtilisateurManager(BaseUserManager):
    def create_user(self, email, prenom, nom, password=None):
        if not email:
            raise ValueError('Les utilisateurs doivent avoir une adresse e-mail')
        user = self.model(
            email=self.normalize_email(email),
            prenom=prenom,
            nom=nom,
        )
        user.set_password(password)
        user.save(using=self._db)
        return user

    def create_superuser(self, email, prenom, nom, password=None):
        user = self.create_user(
            email=email,
            password=password,
            prenom=prenom,
            nom=nom,
        )
        user.is_admin = True
        user.save(using=self._db)
        return user

class Utilisateur(AbstractBaseUser):
    prenom = models.CharField(max_length=150)
    nom = models.CharField(max_length=150)
    email = models.EmailField(unique=True, max_length=150)
    telephone = models.CharField(max_length=15, blank=True)
    date_naissance = models.DateField(blank=True, null=True)
    password = models.CharField(max_length=150)
    statut = models.CharField(max_length=50, default='client')  # 'admin' ou 'client'

    objects = UtilisateurManager()

    USERNAME_FIELD = 'email'
    REQUIRED_FIELDS = ['prenom', 'nom']  # Champs requis pour l'inscription

    def __str__(self):
        return f"{self.prenom} {self.nom}"

    class Meta:
        db_table = 'utilisateur'
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

class CommandeProduit(models.Model):
    commande = models.ForeignKey(Commande, on_delete=models.CASCADE, related_name='details')
    produit = models.ForeignKey(Pokedex, on_delete=models.CASCADE)
    quantite = models.IntegerField()

    def __str__(self):
        return f"{self.quantite} x {self.produit.nom} pour commande {self.commande.numero_commande}"

    class Meta:
        db_table = 'commande_produit'  # Assure-toi d'ajouter ce modèle dans la base de données

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

class Avis(models.Model):
    utilisateur = models.ForeignKey(Utilisateur, on_delete=models.CASCADE)
    produit = models.ForeignKey(Pokedex, on_delete=models.CASCADE)
    note = models.IntegerField()
    commentaire = models.TextField()
    date_creation = models.DateTimeField(default=timezone.now)

    class Meta:
        db_table = 'avis'  # Correspond à la table existante 'paiement'
        managed = False
    def __str__(self):
        return f"Avis de {self.utilisateur.prenom} pour {self.produit.nom}"