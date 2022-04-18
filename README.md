# Guide de démarrage (dev)

1. Créer un dossier nginx dans infra/logs/
2. Copier le .env.example en .env et modifier les valeurs
3. Vérifier que la variable d'environnement APP_ENV est bien sur dev
4. Exécuter dans le container ``composer install``
5. Exécuter dans le container ``npm install``
6. Exécuter dans le container ``bin/console assets:install``
7. Exécuter dans le container ``bin/console yarn encore dev``
8. Exécuter dans le container ``bin/console d:m:m``

Todo: Automatiser une partie des étapes (création du dossier, exécution des commandes ...) avec une commande du Makefile.
