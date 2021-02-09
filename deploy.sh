#!/bin/bash

full=false
run=true

#lees parameters in
until [ -z "$1" ]  # Until all parameters used up...
do
   case "$1" in
        --full|-f) full=true;;
        -h) echo "usage: $0 [--full|-f]
    -full|-f     Perform composer and npm install"
	    run=false;;
    esac
    shift
done

if [ "$run" = true ]
then
    # fetch code
    git pull

    if [ "$full" = true ]
    then
        # check for new requirements
        composer install
        npm install --force
    fi

    # run migrations
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

    # make stylesheets
    npm run build

    # clear cache
    php bin/console cache:clear
fi