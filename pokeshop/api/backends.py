from django.contrib.auth.backends import BaseBackend
from django.contrib.auth.hashers import check_password
from .models import Utilisateur

class CustomUserBackend(BaseBackend):
    def authenticate(self, request, email=None, password=None, **kwargs):
        try:
            # Cherche l'utilisateur par email
            utilisateur = Utilisateur.objects.get(email=email)
            
            # Vérifie si le mot de passe correspond
            if check_password(password, utilisateur.password):
                return utilisateur
        except Utilisateur.DoesNotExist:
            return None

    def get_user(self, user_id):
        try:
            return Utilisateur.objects.get(pk=user_id)
        except Utilisateur.DoesNotExist:
            return None