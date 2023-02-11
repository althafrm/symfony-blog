# Symfony Blog

This project is developed with Symfony version 6.2.5 and requires PHP version 8.1.0 or higher to run.

## Project Setup

- Create database with a suitable name (`symfony_blog`) on a preferred MySQL client

    ```
    CREATE DATABASE symfony_blog;
    ```

- Create `.env.local`

    ```
    touch .env.local
    ```

- Set database credentials in the .env.local file (assuming the following)

    - DBMS: `MySQL`
    - DBMS Version: `5.7.*`
    - DB Name: `symfony_blog`
    - DB Username: `root`
    - DB Password:

    ```
    DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_blog?serverVersion=5.7"
    ```

- Install dependencies
    ```
    composer install
    npm install
    ```

- Compile assets

    ```
    npm run dev
    ```

- Run database migrations and fixtures

    ```
    php bin/console doctrine:database:drop --force
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
    ```

- Start server on port 8000
    
    The command below assumes that [Symfony CLI](https://symfony.com/download) is installed on the development environment.

    ```
    symfony server:start --port=8000
    ```

Blog homepage: `http://localhost:8000/movies`
