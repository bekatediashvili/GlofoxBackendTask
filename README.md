## About

This project uses Laravel Sail which includes PHP 8.2, MySQL. You will not need to install any of these in order to get started. 

## Setting up local dev server

In order to start local dev server, ony thing you need is Docker on your OS. But, it can be configured as XAMPP or any other tool.


1. Create `.env` file

    ```bash
     docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    alpine:latest \
    /bin/sh -c "cp .env.example .env"
    ```
   

2. Install composer requirements:
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```
3. Run laravel sail

    ```bash
    ./vendor/bin/sail up -d
    ```

6. Generate key, map storage as public, run migrations

    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan storage:link
    ./vendor/bin/sail artisan migrate
    ./vendor/bin/sail restart
    ```

Your local environment is ready to be used

## Project specific notes

In this platform, we have: Studios, Courses and bookings.

User can register, login or proceed as guest in order to interact with these resources.

First, you will need to either register or call guest endpoint.

Then you should screate studio. After that, you create class and are able to book a day.

## Api documentation

All endpoints are described on route: `http://localhost/docs`

Additionally, Postman collection is included in repository with name `postman-collection.json`
