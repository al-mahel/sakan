# Sakan

Sakan is a Laravel-based real estate platform for discovering
properties, apartments, rooms, and universities in Egypt.

## Requirements

Before starting the project, make sure you have the following installed:

-   PHP 8.2 or higher
-   Composer
-   MySQL 8.0+ (or a compatible MySQL/MariaDB version)
-   Node.js 18+ and npm
-   Git

Recommended PHP extensions:

-   BCMath
-   Ctype
-   Fileinfo
-   JSON
-   Mbstring
-   OpenSSL
-   PDO
-   PDO MySQL
-   Tokenizer
-   XML

------------------------------------------------------------------------

## 1. Clone the Project

Clone the repository:

``` bash
git clone <YOUR_REPOSITORY_URL>
cd sakan
```

If you already have the project files, simply open a terminal inside the
project directory.

------------------------------------------------------------------------

## 2. Install PHP Dependencies

Run:

``` bash
composer install
```

------------------------------------------------------------------------

## 3. Install Frontend Dependencies

Run:

``` bash
npm install
```

------------------------------------------------------------------------

## 4. Configure Environment

Copy the example environment file:

``` bash
cp .env.example .env
```

On Windows, you can copy `.env.example` manually and rename the copy to
`.env`.

Generate the Laravel application key:

``` bash
php artisan key:generate
```

------------------------------------------------------------------------

## 5. Configure the Database

Create a MySQL database for the project.

For example:

``` sql
CREATE DATABASE sakan;
```

Then update the database section in `.env`:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sakan
DB_USERNAME=root
DB_PASSWORD=
```

Use the correct username, password, host, and port for your local MySQL
installation.

------------------------------------------------------------------------

## 6. Run Migrations

Create the required database tables:

``` bash
php artisan migrate
```

If the project contains seeders and you want to populate the database
with sample data, run:

``` bash
php artisan db:seed
```

Or run migrations and seeders together:

``` bash
php artisan migrate --seed
```

> If you are setting up the project for the first time,
> `php artisan migrate --seed` is usually the easiest option.

------------------------------------------------------------------------

## 7. Create the Storage Link

Laravel uses the `storage` directory for uploaded/public files.

Run:

``` bash
php artisan storage:link
```

This creates the required link from:

``` text
public/storage
```

to:

``` text
storage/app/public
```

------------------------------------------------------------------------

## 8. Build / Run Frontend Assets

For development, run:

``` bash
npm run dev
```

Keep this terminal running while developing.

------------------------------------------------------------------------

## 9. Start the Laravel Application

Open another terminal in the project directory and run:

``` bash
php artisan serve
```

The application will normally be available at:

``` text
http://127.0.0.1:8000
```

or:

``` text
http://localhost:8000
```

------------------------------------------------------------------------

## 10. Run Everything During Development

You will normally need two terminal windows.

### Terminal 1

``` bash
php artisan serve
```

### Terminal 2

``` bash
npm run dev
```

Then open:

``` text
http://127.0.0.1:8000
```

------------------------------------------------------------------------

# Production Build

When you are ready to build frontend assets for production:

``` bash
npm run build
```

Then make sure your Laravel application is configured with the correct
production `.env` values.

------------------------------------------------------------------------

# Useful Laravel Commands

### Clear application cache

``` bash
php artisan optimize:clear
```

### Clear configuration cache

``` bash
php artisan config:clear
```

### Clear route cache

``` bash
php artisan route:clear
```

### Clear view cache

``` bash
php artisan view:clear
```

### Check available routes

``` bash
php artisan route:list
```

### Run migrations

``` bash
php artisan migrate
```

### Reset and recreate the database

**Warning:** This deletes existing database data.

``` bash
php artisan migrate:fresh --seed
```

------------------------------------------------------------------------

# Common Setup Issues

## 1. `No application encryption key has been specified`

Run:

``` bash
php artisan key:generate
```

------------------------------------------------------------------------

## 2. Database connection error

Check the following values in `.env`:

``` env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sakan
DB_USERNAME=root
DB_PASSWORD=
```

Make sure MySQL is running and the database exists.

After changing `.env`, run:

``` bash
php artisan optimize:clear
```

------------------------------------------------------------------------

## 3. Images or uploaded files are not displaying

Run:

``` bash
php artisan storage:link
```

Then clear the application cache:

``` bash
php artisan optimize:clear
```

------------------------------------------------------------------------

## 4. CSS or JavaScript changes are not appearing

Make sure Vite is running:

``` bash
npm run dev
```

For a production build:

``` bash
npm run build
```

------------------------------------------------------------------------

## 5. Composer dependency errors

Make sure your PHP version satisfies the project's requirements, then
run:

``` bash
composer install
```

If the `vendor` directory exists but dependencies appear corrupted, you
can remove it and reinstall:

``` bash
rm -rf vendor
composer install
```

On Windows, delete the `vendor` directory manually and run:

``` bash
composer install
```

------------------------------------------------------------------------

# Project Structure

The project follows the standard Laravel structure:

``` text
sakan/
├── app/
│   ├── Http/
│   ├── Models/
│   └── ...
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

------------------------------------------------------------------------

# Development Workflow

After the initial setup:

``` bash
# Start Laravel
php artisan serve

# Start Vite
npm run dev
```

Then visit:

``` text
http://127.0.0.1:8000
```

------------------------------------------------------------------------

# Important

Do not commit your `.env` file to Git.

The `.env` file contains environment-specific configuration and may
contain sensitive credentials.

Use `.env.example` as the template for other developers.
