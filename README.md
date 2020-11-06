# Muzeo

The project is a Symfony 4.3 based application which is developped in a docker environment.

## Why ?
---
Muzéo : Aide à la création des devis

## Requirements
---
* Serveur Apache
* PHP 7.2
* Mysql 5.7
* composer
* wkhtmltopdf 0.12.3 (with patched qt)
* Docker (Development)
* Node 12.13.0
* Yarn 1.19.1
* Npm  6.10.2


Installation
------------

## Initialization from docker
1. Run install command
```
make install
```

2. Import database from host
```
./bin/db_import.sh YOUR_MYSQL_FILE_NAME.sql
```

## Docker config override (optionnel)
You can override your docker-compose on `docker-compose.override.yml`

## Installation Front-end
```sh
PROD:
# install dependencies (yarn install && yarn encore production)
cd app/integration && yarn run start:prod
```
```sh
DEV:
# install dependencies (yarn install && yarn run encore dev)
cd app/integration && yarn run start:dev
```

Troubleshooting
---------------
/

FAQ
---
/

Usage
-----

#### Cron
/

#### CLI
/

#### Running Tests
/

Deploy
-----------
```sh
make deploy
```

Documentation
-------------

## Docker operations
### Launch containers
```
make up
```
Or
```
docker-compose up -d
```

### Docker connect
```
make bash
```
Or
```
docker-compose exec apache bash
```
### Restart containers
```
make restart
```

### Stop containers
```
make stop
```
Or
```
docker-compose stop
```
### Remove containers
```
make clean
```
### Copy the vendor locally
```
docker cp muzeo_apache_1:/var/www/symfony/vendor   app/symfony/
```
## Authors / Maintainers
---

- Sofiane Souidi
- Fabrice Metayer
- Géraldine Bonnel
- Eric Defiez
