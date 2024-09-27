from django.shortcuts import render, get_object_or_404
from rest_framework import viewsets, status
from rest_framework.response import Response
from rest_framework.views import APIView
from rest_framework.decorators import action
from .models import Utilisateur, Commande, Pokedex
from .serializers import UtilisateurSerializer, CommandeSerializer, PokedexSerializer

# Vue pour gérer les utilisateurs
class UtilisateurViewSet(viewsets.ModelViewSet):
    queryset = Utilisateur.objects.all()
    serializer_class = UtilisateurSerializer

    # Accéder au profil d'un utilisateur spécifique
    @action(detail=True, methods=['get'])
    def profil(self, request, pk=None):
        utilisateur = get_object_or_404(Utilisateur, pk=pk)
        serializer = self.get_serializer(utilisateur)
        return Response(serializer.data)

    # Accéder à l'historique des commandes d'un utilisateur
    @action(detail=True, methods=['get'])
    def commandes(self, request, pk=None):
        utilisateur = get_object_or_404(Utilisateur, pk=pk)
        commandes = Commande.objects.filter(utilisateur_id=utilisateur.id)
        serializer = CommandeSerializer(commandes, many=True)
        return Response(serializer.data)

# Vue pour enregistrer un utilisateur
class UserRegisterView(APIView):
    def post(self, request):
        serializer = UtilisateurSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
# Vue pour modifier ou supprimer un utilisateur
class UserUpdateDeleteView(APIView):
    def put(self, request, pk):
        utilisateur = get_object_or_404(Utilisateur, pk=pk)
        serializer = UtilisateurSerializer(utilisateur, data=request.data, partial=True)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
    def delete(self, request, pk):
        utilisateur = get_object_or_404(Utilisateur, pk=pk)
        utilisateur.delete()
        return Response(status=status.HTTP_204_NO_CONTENT)

# Vue pour gérer les commandes
class CommandeViewSet(viewsets.ModelViewSet):
    queryset = Commande.objects.all()
    serializer_class = CommandeSerializer

    # Suivre l'état de la livraison
    @action(detail=True, methods=['get'], url_path='suivi-livraison')
    def suivi_livraison(self, request, pk=None):
        commande = self.get_object()
        return Response({
            "numero_commande": commande.numero_commande,
            "statut_livraison": commande.statut_livraison,
            "adresse_livraison": commande.adresse_livraison,
            "ville": commande.ville,
            "code_postal": commande.code_postal
        })

    # Mettre à jour les informations de livraison
    @action(detail=True, methods=['put'], url_path='update-livraison')
    def update_livraison(self, request, pk=None):
        commande = self.get_object()
        commande.adresse_livraison = request.data.get('adresse_livraison', commande.adresse_livraison)
        commande.ville = request.data.get('ville', commande.ville)
        commande.code_postal = request.data.get('code_postal', commande.code_postal)
        commande.statut_livraison = request.data.get('statut_livraison', commande.statut_livraison)
        commande.save()
        return Response({
            "message": "Les informations de livraison ont été mises à jour.",
            "adresse_livraison": commande.adresse_livraison,
            "ville": commande.ville,
            "code_postal": commande.code_postal,
            "statut_livraison": commande.statut_livraison
        }, status=status.HTTP_200_OK)

# Vue pour gérer le Pokedex
class PokedexViewSet(viewsets.ModelViewSet):
    queryset = Pokedex.objects.all()
    serializer_class = PokedexSerializer

    # Endpoint pour vérifier les niveaux de stock
    @action(detail=False, methods=['get'], url_path='stock')
    def check_stock(self, request):
        produits_disponibles = Pokedex.objects.filter(quantite__gt=0)
        serializer = self.get_serializer(produits_disponibles, many=True)
        return Response(serializer.data, status=status.HTTP_200_OK)

    # Endpoint pour mettre à jour les niveaux de stock après commande
    @action(detail=True, methods=['post'], url_path='update-stock')
    def update_stock(self, request, pk=None):
        produit = self.get_object()
        quantite_commandee = request.data.get('quantite', 0)

        # Vérifie si la quantité est valide
        if produit.quantite >= int(quantite_commandee):
            produit.quantite -= int(quantite_commandee)
            produit.save()
            return Response({"message": "Stock mis à jour avec succès"}, status=status.HTTP_200_OK)
        else:
            return Response({"error": "Quantité insuffisante en stock"}, status=status.HTTP_400_BAD_REQUEST)