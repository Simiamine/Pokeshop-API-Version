from rest_framework.routers import DefaultRouter
from .views import UtilisateurViewSet, CommandeViewSet

router = DefaultRouter()
router.register(r'utilisateurs', UtilisateurViewSet)
router.register(r'commandes', CommandeViewSet)

urlpatterns = router.urls
