#!/bin/bash

# fetch code
git pull

# check for new requirements
composer install
npm install --force

# run migrations
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# make stylesheets
npm run build

# clear cache
php bin/console cache:clear