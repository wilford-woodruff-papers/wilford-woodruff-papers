<p align="center"><a href="https://wilfordwoodruffpapers.org/img/image-logo.png" width="400"></a></p>

## Getting Started with Development

Clone the Github repository

```git clone https://github.com/wilford-woodruff-papers/wilford-woodruff-papers```

## Docker

Both local development options use Docker. You first need to install Docker Desktop or OrbStack for your operating system.
 - [OrbStack](https://orbstack.dev/) (Mac and Linux only)
 - [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Mac, Linux, and Windows)

## Options for Local Development
There are 2 supported options for doing local development: 
 - [Herd](https://herd.laravel.com/) + [DBngine](https://dbngin.com/) (Mac only)
 - [Sail](https://laravel.com/docs/10.x/sail) (Mac, Linux, and Windows)

### Using Herd + Docker Meilisearch

Herd is a recently released desktop application that handles configuring PHP and local development domains/SSL. However, since the project uses Meilisearch, you will need to run Meilisearch in a separate Docker container. 

DBngin is a Mac only application that handles configuring MySQL and Redis.

```
docker run -it --rm --name=meilisearch -p 7700:7700 -v ~/code/meilisearch/meili_data:/meili_data getmeili/meilisearch:v1.3 meilisearch --master-key="6DWfC5xQuDulEUhYjGGwVAS00tpZxKlPpc71Fkpr2CQ"
```

You can then use the following connect parameters in your .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wwp
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MEILISEARCH_HOST=http://meilisearch.orb.local:7700
MEILISEARCH_KEY="6DWfC5xQuDulEUhYjGGwVAS00tpZxKlPpc71Fkpr2CQ"
```


### Using Sail

Sail is a fully configured Docker environment for Laravel.

#### Installing Sail (Docker)

You may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'```

Copy .env file to the root or your project directory

You can then use the following connect parameters in your .env

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=wwp
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=masterKey

RAY_HOST=host.docker.internal
RAY_PORT=23517
RAY_REMOTE_PATH='/var/www'
RAY_LOCAL_PATH='~/code/wilford-woodruff-papers'
```

Install PHP dependencies

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

#### Setup of Sail and Installing Composer Dependencies

```./vendor/bin/sail up```

```./vendor/bin/sail composer install```

```./vendor/bin/sail up``` or if you created the alias ```sail up```

To make sure the packages are correct for the docker version of PHP run composer again

```sail composer install```

## Install Node Modules

```npm install```

Assets are compiled using Lasso during deployment. To compile assets locally, run one of the following:

```
npm run dev
npm run watch
npm run prod
```

## Import the sample database


## Edit hosts file

OSX ```sudo nano /private/etc/hosts```


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

