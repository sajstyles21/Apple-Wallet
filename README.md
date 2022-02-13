# Please follow the below steps in the given order for project installation.

Clone project with command `git clone https://github.com/sajstyles21/Apple-Wallet.git`.

Run `cd path-to-project` //Go to the root of project

Run `composer update`

Run `cp .env.example .env` for copying .env.example to .env and add DB credentials.

NOTE - Please update `APP_URL` to `http://127.0.0.1:8000` or `http://localhost:8000` according to your local base url in the .env file.

Run `php artisan migrate` for migrations.

Run `php artisan db:seed` for users seeding.

Run `php artisan key:generate` for generating encryption key.

Run `php artisan storage:link` for creating storage links.

Start server by command `php artisan serve`.

Local URL for creating business card -
URL - http://127.0.0.1:8000/create-pass

IMPORTANT - Please update `APP_URL` in the .env file for your base URL according to the server (live server or local server).

Possible local URLs -

http://127.0.0.1:8000/create-pass

http://localhost:8000/create-pass

Live URL -

http://`live-base-url`/create-pass
