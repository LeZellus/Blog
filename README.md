# Xipel Blog

## Prérequis
 - git
 - gitmoji lastest
 - PHP >= 8
 - yarn

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
php bin/console assets:install public
symfony console elfinder:install
```

Créez un dossier images_ckeditor dans `public/uploads`
```
mkdir public/uploads
mkdir public/uploads/images_ckeditor
```

Compilez vos fichiers :
```
yarn encore dev --watch
```

Créer un hook gitmoji :
```
gitmoji -i
```
