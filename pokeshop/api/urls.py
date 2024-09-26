from rest_framework.routers import DefaultRouter
from .views import UtilisateurViewSet, CommandeViewSet, PokedexViewSet

router = DefaultRouter()
router.register(r'utilisateurs', UtilisateurViewSet)
router.register(r'commandes', CommandeViewSet)
router.register(r'pokedex', PokedexViewSet)

urlpatterns = router.urls
