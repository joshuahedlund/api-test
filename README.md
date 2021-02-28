## api-test

api-test is a simple api for profiles and interactions.

## Set Up

Requirements:

- PHP 7.0+
- MySQL 5.7.22+ / MariaDB 10.5+
- composer

Set up vendor files

> composer update

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

> php artisan key:generate --show
> > base64:xxxxxxxxxxx

If APP_KEY is not added to .env automatically, add manually

> APP_KEY=base64:xxxxxxxxxxx

Run database migrations

> php artisan migrate

Run database seeding (if desired)

> php artisan db:seed

Start server:

> php artisan serve

Visit on `localhost:8000`

## Endpoints

> GET /profile/{id}

View a profile

> GET /profiles/list

View list of profiles

- `?includeInteractions` to include interactions in records
- `?all` to return all results as a single page
- `?page={int}` to return results by page

> GET /interaction/{id}

View an interaction

> POST /profile/{id}/create

Create a profile

> POST /profile/{id}/update

Update a profile

> POST /profile/{id}/delete

Delete a profile

> POST /profile/{id}/create-interaction

Create an interaction

