# mass-api

Laravel Sonarr / Radarr / Tranmission / Jackett wrapper with added token based authentication and user permissions.

There are two ways of using this API. You can spin up your own containers and provide the details in the .env or you can use the provided docker-compose script to create them automatically. 


## Setup

### Automatic mode

If you use automatic mode, replace all `docker-compose` commands in this readme with `docker-compose -f docker-compose.yml -f docker-compose.apps.yml`. To make your life easier you can add an alias by running `source bash-alias.sh` and then using `docker-compose-mass`. Or add an alias to ".bashrc".

### First setup

Setup environment according to desired setup. Edit the values!

```bash
cp .env.example .env
```

Start containers

```bash
docker-compose up -d
```

Make sure all containers are running (`docker container ps`).

Spawn an interactive shell with:

```bash
docker-compose exec laravel sh
```

Initialize app

```bash
composer initialize
```
:warning: `composer initialize` resets API database, so use with care

#### Optional

To automatically setup the connections for Sonarr / Radarr and Transmission / Jacket run the following command.
* Not needed if `MANUAL_CONFIG=true` (does nothing :D).
* :warning: If `MANUAL_CONFIG=false` then it overwrites existing DB values from docker containers, so use with care.

```bash
composer initialize-auto-mode
```

### Development


Run the tests that are being checked by GitHub actions 

```bash
composer test
```

### Tokens

Generate a new Authorization Bearer token for the admin user:

```
php artisan auth:token
```

### Update

After pulling an update run:

```bash
docker-compose up -d
docker-compose exec laravel composer update-app
```
