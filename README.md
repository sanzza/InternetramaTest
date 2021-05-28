# Internetrama Test


[![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg)](http://forthebadge.com)  

Test technique

## Pour commencer

Lancer  `` composer install ``

Executez la commande ``php bin/console doctrine:database:create ``

Suivi de ``php bin/console make:migration ``

et de ``php bin/console doctrine:migrations:migrate ``

## GetSocietyBySiret

Executez la commande ``php bin/console app:get-society  {{siret}}``

`` {{siret}}`` == n° siret de la société recherchée (14 chiffres)
## Exemple de Résultat

![Optional Text](images/screenshot.png)