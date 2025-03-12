#!/bin/bash

if [ ! -f "composer.json" ]; then
    composer create-project symfony/skeleton .
    composer require api
    composer require symfony/orm-pack
    composer require symfony/maker-bundle --dev
fi

composer install

php -S 0.0.0.0:8000 -t public