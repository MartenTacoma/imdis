IMDIS 2021 website using the Symfony Framework

## Installation

Create a directory and cd into it

Clone the git repo using `git clone https://github.com/MartenTacoma/imdis.git .`

run `composer install` to install all composer requirements

run `npm install` to install all stuff needed to generate js and css files

Create a database (MariaDB) using the tool of your preference.

Create file `.env.local` in the root directory with

```
DATABASE_URL="mysql://[user]:[pass]@[host|ip]:[port]]/[database]?serverVersion=mariadb-10.5.8"
MAILER_DSN="smtp://[user]:[pass]@[host|ip]:[port]"
REGISTRATION_STATUS="future"
DASHBOARD="true"
DASHBOARD_ROLE="ROLE_ADMIN"
PRESENTATION_SUBMISSION="[any presentation submission instructions]"
DETAILS_ROLE="ROLE_ADMIN"
```
*documentation of all options has to be writen*

run `php bin/console doctrine:migrations:migrate` to initialize database

run `npm run build` to generate stylesheets

Use your favorite webserver to serve the public folder. The website should now work.

Run `composer dump-env prod` to generate production configuration, this will disable debug info