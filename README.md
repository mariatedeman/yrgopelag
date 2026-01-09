# YRGOPELAG – Sjöboda B&B

Booking experience for a fictional Bohuslän B&B built for the Yrgopelag challenge. The app lets guests fetch a transfer code from the Central Bank API, pick rooms and paid extras, and complete a booking with a receipt posted back to the bank. Admins can review bookings and update pricing. Stack: PHP 8, SQLite, vanilla JS/CSS, Dotenv, strict types.

## URL
- Live demo: https://made-by-met.se/yrgopelag
- Local root URL when running via PHP built-in server: `http://localhost:8000`

## Features
- Guest flow: request transfer code, choose room, add extras, submit booking, see receipt.
- Pricing: dynamic totals based on room, extras, and loyalty discount trigger.
- Admin: login-gated dashboard to list bookings and update room/feature prices.
- Data seed: SQLite schema and starter data created on boot (rooms, features, trigger for total nights).
- API integrations: Central Bank endpoints for withdraw, validate transfer code, deposit, and post receipt.

## Prerequisites
- PHP 8.1+ with SQLite extension enabled
- Composer

## Setup (local)
1) Install dependencies
```sh
composer install
```
2) Configure environment
```sh
cp .env.example .env
# Open .env and set API_KEY from the Central Bank
```
3) Run the app
```sh
php -S localhost:8000
```
4) Open `http://localhost:8000` in the browser.

## Project structure
- `index.php` – entrypoint rendering landing, booking, and feature sections.
- `app/autoload.php` – loads Dotenv, starts session, boots SQLite (`app/data/yrgopelag.db`), seeds schema/data.
- `app/functions.php` – Central Bank API calls, transfer code validation, receipt posting, feature helpers.
- `app/data/setup.php` – schema creation, seed data, trigger for guest total nights.
- `app/views/` – booking form, transfer code flow, receipt view, room presentation.
- `app/posts/` – form handlers (booking submission, transfer code, auth, price updates).
- `assets/` – styles, scripts, images.

## Testing notes
No automated test suite yet; exercise flows manually:
- Request a transfer code, then submit a booking with valid dates and room.
- Toggle add-on features to confirm total updates.
- Validate loyalty discount application when applicable.
- In admin, adjust a price and confirm the change appears in booking totals.

## Deployment
- Build is PHP-only; ensure `.env` contains `API_KEY` in production.
- SQLite database lives in `app/data/yrgopelag.db`. For stateless hosting, consider moving to external DB or resetting the file per deploy.

## License
MIT

##
Review from Wilma

Remember not to upload the database to github, write it in your .gitignore for better security.

Try using guzzle next time for easier coding, could be used in this project to 'talk' to the central bank when validating transfercode and deposit. Guzzle is a way to interact with an API.

Good clear js with good comments, you can split the js to make it even clearer by split them into more files.

Try to use one unit in css instead of many, for example try to keep it constant with rem or px or whatever you prefer. Otherwise it's fine css with good comments and splitting.

You have your script tag for js at the top of footer.php. Put it at the bottom of the code just above </body> so that all html can be loaded first for a faster page. 

Out-commented code in library-components.css can be removed for cleaner code.

“declare(strict_types=1);” You don't need to have this at the beginning of the files where you have require "/autoload.php" because you already have it in autoload. I see you have it in almost all of your files. 
