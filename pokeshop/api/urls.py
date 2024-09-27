from rest_framework.routers import DefaultRouter
from django.urls import path, include
from .views import UtilisateurViewSet, CommandeViewSet, PokedexViewSet, UserRegisterView, UserUpdateDeleteView

router = DefaultRouter()
router.register(r'utilisateurs', UtilisateurViewSet)
router.register(r'commandes', CommandeViewSet)
router.register(r'pokedex', PokedexViewSet)

# Ajout des routes spécifiques pour les utilisateurs
urlpatterns = router.urls
urlpatterns += [
    path('utilisateurs/<int:pk>/profil/', UtilisateurViewSet.as_view({'get': 'profil'}), name='utilisateur-profil'),
    path('utilisateurs/<int:pk>/commandes/', UtilisateurViewSet.as_view({'get': 'commandes'}), name='utilisateur-commandes'),
    path('inscription/', UserRegisterView.as_view(), name='inscription'),
    path('utilisateurs/<int:pk>/modifier/', UserUpdateDeleteView.as_view(), name='modifier-utilisateur'),
    path('utilisateurs/<int:pk>/supprimer/', UserUpdateDeleteView.as_view(), name='supprimer-utilisateur'),
    path('commandes/<int:pk>/suivi-livraison/', CommandeViewSet.as_view({'get': 'suivi_livraison'}), name='suivi-livraison'),
    path('commandes/<int:pk>/update-livraison/', CommandeViewSet.as_view({'patch': 'update_livraison'}), name='update-livraison'),

]