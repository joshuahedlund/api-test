## api-test

api-test is a simple api for profiles and interactions.

## Set Up

Requirements:

- PHP 7.0+
- MySQL 5.7.22+ / MariaDB 10.5+

Add .env file with database credentials

> DB_CONNECTION=mysql
>
> DB_HOST=
>
> DB_PORT=
>
> DB_DATABASE=
>
> DB_USERNAME=
>
> DB_PASSWORD=

Set up APP_KEY in .env

> php artisan key:generate 

Run database migrations

> php artisan migrate

Start server:

> php artisan serve

Visit on `localhost:8000`

## Endpoints

View a profile

> GET /profile/{id}

View all profiles

> GET /profiles/list

View all profiles with interactions

> GET /profiles/list?includeInteractions

View an interaction

> GET /interaction/{id}

Create a profile

> POST /profile/{id}/create

Update a profile

> POST /profile/{id}/update

Delete a profile

> POST /profile/{id}/delete

Create an interaction

> POST /profile/{id}/create-interaction
