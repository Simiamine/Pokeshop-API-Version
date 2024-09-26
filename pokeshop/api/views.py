from django.shortcuts import render
from rest_framework import viewsets
from .models import Utilisateur, Commande, Pokedex
from .serializers import UtilisateurSerializer, CommandeSerializer, PokedexSerializer

# Vue pour gérer les utilisateurs
class UtilisateurViewSet(viewsets.ModelViewSet):
    queryset = Utilisateur.objects.all()
    serializer_class = UtilisateurSerializer

# Vue pour gérer les commandes
class CommandeViewSet(viewsets.ModelViewSet):
    queryset = Commande.objects.all()
    serializer_class = CommandeSerializer

class PokedexViewSet(viewsets.ModelViewSet):
    queryset = Pokedex.objects.all()
    serializer_class = PokedexSerializer