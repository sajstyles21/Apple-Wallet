# Source code for creating business card and add to apple wallet.

Run `composer update`

copy .env.example to .env and add DB credentials.

Run `php artisan migrate` for migrations.

Run `php artisan db:seed` for users seeding

Local URL for creating business card -
URL - http://127.0.0.1:8000/create-pass

Start server by command `php artisan serve`

NOTE - Please update `APP_URL` in the .env file for your base URL whether it is live server or local server.

Possible local URLs -

http://127.0.0.1:8000/create-pass

http://localhost:8000/create-pass

Live URL -

http://`live-base-url`/create-pass
