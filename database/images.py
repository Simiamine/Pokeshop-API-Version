import os
import requests

# Répertoire de destination pour les images
destination_folder = '../img'

# Crée le dossier de destination s'il n'existe pas
if not os.path.exists(destination_folder):
    os.makedirs(destination_folder)

# Boucle pour télécharger les images de 001 à 151
for i in range(1, 152):
    # Génère l'ID avec le padding (ex : 001, 002, etc.)
    pokemon_id = f'{i:03}'  # Formate l'ID pour avoir 3 chiffres
    image_url = f'https://raw.githubusercontent.com/HybridShivam/Pokemon/master/assets/images/{pokemon_id}.png'
    image_path = os.path.join(destination_folder, f'{pokemon_id}.png')

    try:
        # Télécharge l'image
        response = requests.get(image_url, stream=True)
        if response.status_code == 200:
            with open(image_path, 'wb') as file:
                for chunk in response.iter_content(1024):
                    file.write(chunk)
            print(f"Téléchargé: {image_url}")
        else:
            print(f"Erreur: Impossible de télécharger {image_url}, Code HTTP: {response.status_code}")
    except Exception as e:
        print(f"Exception: Impossible de télécharger {image_url}, Erreur: {e}")