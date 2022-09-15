# [CODING TEST - SR DEVELOPER - Coding Collective]

## Quickstart
```sh
git clone
cp .env.example .env

# create empty database and configure the connection
composer install
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Requirements

1. create database using mysql :white_check_mark:
2. create using laravel framework :white_check_mark:
3. create login logout system by level system.
eg for leveling sistem :
    - Mr. John -> Senior HRD -> Senior HRD can view, read, edit, add :white_check_mark:
    - Mrs. Lee -> HRD -> HRD only view and read :white_check_mark:
4. create CRUD Form for Candidate List :white_check_mark:

    ```
    Name. ex : smith
    Education. ex : UGM Yogyakarta
    Birthday. ex : 1991-01-19
    Experience. ex : 5 Year
    Last Position. ex : CEO
    Applied Position. ex : Senior PHP Developer
    Top 5 Skills. ex : Laravel, Mysql, PostgreSQL, Codeigniter, Java
    Email. ex : smith@gmail.com
    Phone. ex : 085123456789
    Resume. ex : only pdf file
    ```

5.  build API to fetch all, add, edit, and delete data Candidate. :white_check_mark:
    completed with OAUTH2. :x:
    create using laravel and with swagger :warning:
6. create unit testing using phpunit laravel :x:

## Api Documentation

Import `Coding-Collective.postman_collection.json` to [Postman](https://www.postman.com/downloads/)
