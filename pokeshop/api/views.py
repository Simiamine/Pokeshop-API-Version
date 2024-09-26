from django.shortcuts import render
from rest_framework import viewsets
from .models import Utilisateur, Commande
from .serializers import UtilisateurSerializer, CommandeSerializer

# Vue pour gérer les utilisateurs
class UtilisateurViewSet(viewsets.ModelViewSet):
    queryset = Utilisateur.objects.all()
    serializer_class = UtilisateurSerializer

# Vue pour gérer les commandes
class CommandeViewSet(viewsets.ModelViewSet):
    queryset = Commande.objects.all()
    serializer_class = CommandeSerializer
