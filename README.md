# AEMFS - Prog Web Back End

Vous voici dans la partie backend du site AEMFS.

Dans le code source il vous est proposé un set de 4 données, que vous pouvez
ajouter automatiquement après la création de votre base de données.

Soyez sûrs d'avoir installé les dépendances de Laravel :
https://laravel.com/docs/7.x/installation#server-requirements

##Comment démarrer le back-end ?

###1. Configurer son .env

Copiez le .env.example et remplissez le.

N'oubliez pas de générer la clé secrète.

```
php artisan key:generate
```

###2. Effectuer la migration

```
php artisan migrate --database=nom_db_dans_config
```

###3. Effectuer le seedage (remplir la bdd)

```
php artisan db:seed
```

Si une erreur apparait, disant que le dossier n'existe pas, essayez de
créer vos dossiers manuellement : `storage/app/images/events`

###4. Créer un lien vers les dossier

```
php artisan images:link
```

###5. Lancer l'application !

Par défaut, le port est 8000.

```
php artisan serve --port=8080
```
