# Xipel Blog

## Installation du projet
Clonez le repo avec :
```
git clone git@github.com:LeZellus/Blog.git
```
Puis installez les dépendances PHP :
```
composer install
```
Ainsi que les dépendances JS :
```
yarn install
```

Initialisez les fichiers nécessaires à CKEditor :
```
php bin/console ckeditor:install
```
```
symfony console elfinder:install
```

Compilez vos fichiers :
```
yarn encore dev --watch
```

Créer un hook gitmoji :
```
gitmoji -i
```
