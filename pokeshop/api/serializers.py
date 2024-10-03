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
    produit_nom = serializers.ReadOnlyField(source='produit.nom')  # Afficher le nom du produit

    class Meta:
        model = CommandeProduit
        fields = ['produit_nom', 'quantite']  # Affiche le nom du produit et la quantité

class CommandeSerializer(serializers.ModelSerializer):
    details = CommandeProduitSerializer(many=True)  # Utiliser le serializer des détails

    class Meta:
        model = Commande
        fields = ['id', 'utilisateur_id', 'adresse_livraison', 'ville', 'code_postal', 'livraison', 'total', 'numero_commande', 'date_creation', 'statut', 'statut_livraison']

    def create(self, validated_data):
        # Extraire les produits et quantités
        details_data = validated_data.pop('details')
        commande = Commande.objects.create(**validated_data)

        for detail in details_data:
            produit = detail.get('produit')
            quantite = detail.get('quantite')
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
        fields = '__all__'

    # Hashing du mot de passe avant de le sauvegarder
    def validate_password(self, value):
        return make_password(value)