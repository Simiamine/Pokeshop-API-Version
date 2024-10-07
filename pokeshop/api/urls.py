from rest_framework.routers import DefaultRouter
from rest_framework_simplejwt.views import (
    TokenObtainPairView,
    TokenRefreshView,
)
from django.urls import path, include
from .views import UtilisateurViewSet, CommandeViewSet, PokedexViewSet, UserRegisterView, AvisViewSet, UserUpdateDeleteView, PaiementView, StatutPaiementView, stripe_webhook, LoginView, RecommendationView, GlobalRecommendationView

router = DefaultRouter()
router.register(r'utilisateurs', UtilisateurViewSet)
router.register(r'commandes', CommandeViewSet)
router.register(r'pokedex', PokedexViewSet)
router.register(r'avis', AvisViewSet)

urlpatterns = router.urls
urlpatterns += [
    path('utilisateurs/<int:pk>/profil/', UtilisateurViewSet.as_view({'get': 'profil'}), name='utilisateur-profil'),
    path('utilisateurs/<int:pk>/commandes/', UtilisateurViewSet.as_view({'get': 'commandes'}), name='utilisateur-commandes'),
    path('inscription/', UserRegisterView.as_view(), name='inscription'),
    path('commandes/<int:pk>/suivi-livraison/', CommandeViewSet.as_view({'get': 'suivi_livraison'}), name='suivi-livraison'),
    path('commandes/<int:pk>/update-livraison/', CommandeViewSet.as_view({'patch': 'update_livraison'}), name='update-livraison'),
    path('paiements/traiter/', PaiementView.as_view(), name='paiement-traiter'),
    path('paiements/statut/<str:transaction_id>/', StatutPaiementView.as_view(), name='paiement-statut'),
    path('webhook/', stripe_webhook, name='stripe-webhook'),
    path('produits/<int:pk>/avis/', AvisViewSet.as_view({'get': 'afficher_avis'}), name='afficher-avis'),
    path('produits/<int:pk>/ajouter-avis/', AvisViewSet.as_view({'post': 'ajouter_avis'}), name='ajouter-avis'),
    path('avis/<int:pk>/supprimer-avis/', AvisViewSet.as_view({'delete': 'supprimer_avis'}), name='supprimer-avis'),
    path('auth/login/', LoginView.as_view(), name='login'),
    path('token/', TokenObtainPairView.as_view(), name='token_obtain_pair'),
    path('token/refresh/', TokenRefreshView.as_view(), name='token_refresh'),
    path('recommandations/', GlobalRecommendationView.as_view(), name='global-recommandations'),
    path('utilisateurs/<int:pk>/recommandations/', RecommendationView.as_view(), name='utilisateur-recommandations'),

]