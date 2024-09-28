from rest_framework import serializers
from .models import Utilisateur, Commande, Pokedex, Paiement
from django.contrib.auth.hashers import make_password

class UtilisateurSerializer(serializers.ModelSerializer):
    class Meta:
        model = Utilisateur
        fields = '__all__'

    # Hashing du mot de passe avant de sauvegarder
    def validate_mot_de_passe(self, value):
        return make_password(value)

class CommandeSerializer(serializers.ModelSerializer):
    class Meta:
        model = Commande
        fields = '__all__'

class PokedexSerializer(serializers.ModelSerializer):
    class Meta:
        model = Pokedex
        fields = '__all__'

class PaiementSerializer(serializers.ModelSerializer):
    class Meta:
        model = Paiement
        fields = '__all__'