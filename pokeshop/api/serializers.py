from rest_framework import serializers
from .models import Utilisateur, Commande, Pokedex, Paiement, Avis, CommandeProduit
from django.contrib.auth.hashers import make_password

class UtilisateurSerializer(serializers.ModelSerializer):
    class Meta:
        model = Utilisateur
        fields = '__all__'

    # Hashing du mot de passe avant de sauvegarder
    def validate_mot_de_passe(self, value):
        return make_password(value)

class CommandeProduitSerializer(serializers.ModelSerializer):
    produit = serializers.PrimaryKeyRelatedField(queryset=Pokedex.objects.all())  # Utilise l'ID du produit

    class Meta:
        model = CommandeProduit
        fields = ['produit', 'quantite']  # Utilise l'ID du produit et la quantité

class CommandeSerializer(serializers.ModelSerializer):
    details = CommandeProduitSerializer(many=True)

    class Meta:
        model = Commande
        fields = ['id', 'utilisateur', 'adresse_livraison', 'ville', 'code_postal', 'livraison', 'total', 'numero_commande', 'date_creation', 'statut', 'details']

    def create(self, validated_data):
        # Extraire les détails de la commande
        details_data = validated_data.pop('details', [])

        # Créer la commande principale
        commande = Commande.objects.create(**validated_data)

        # Ajouter les détails de la commande (produits et quantités)
        for detail in details_data:
            produit = detail.get('produit')  # Produit est maintenant un objet Pokedex
            quantite = detail.get('quantite', 1)

            # Crée l'entrée CommandeProduit
            CommandeProduit.objects.create(commande=commande, produit=produit, quantite=quantite)

        return commande

class PokedexSerializer(serializers.ModelSerializer):
    class Meta:
        model = Pokedex
        fields = '__all__'

class PaiementSerializer(serializers.ModelSerializer):
    class Meta:
        model = Paiement
        fields = '__all__'

class AvisSerializer(serializers.ModelSerializer):
    utilisateur = serializers.StringRelatedField()  # Pour afficher un champ lisible de l'utilisateur
    produit = serializers.StringRelatedField()  # Pour afficher un champ lisible du produit

    class Meta:
        model = Avis
        fields = ['id', 'utilisateur', 'produit', 'note', 'commentaire', 'date_creation']

class UtilisateurSerializer(serializers.ModelSerializer):
    class Meta:
        model = Utilisateur
        fields = ['id','prenom', 'nom', 'email', 'telephone', 'date_naissance', 'password', 'statut']

    def create(self, validated_data):
        # Hasher le mot de passe avant de créer l'utilisateur
        validated_data['password'] = make_password(validated_data['password'])
        return super(UtilisateurSerializer, self).create(validated_data)