#!/usr/bin/env python
"""Django's command-line utility for administrative tasks."""
import os
import sys
import platform

def main():
    """Run administrative tasks."""
    # Détection du système d'exploitation et sélection des paramètres appropriés
    if platform.system() == 'Darwin':  # macOS
        os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'pokeshop.settings_mac')
    elif platform.system() == 'Windows':  # Windows
        os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'pokeshop.settings_windows')
    else:  # Pour d'autres systèmes (Linux ou autres)
        os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'pokeshop.settings_windows')

    try:
        from django.core.management import execute_from_command_line
    except ImportError as exc:
        raise ImportError(
            "Couldn't import Django. Are you sure it's installed and "
            "available on your PYTHONPATH environment variable? Did you "
            "forget to activate a virtual environment?"
        ) from exc
    execute_from_command_line(sys.argv)


if __name__ == '__main__':
    main()