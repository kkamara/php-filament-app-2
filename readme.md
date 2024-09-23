<img src="https://github.com/kkamara/useful/blob/main/php-reactjs-boilerplate.png?raw=true" alt="php-reactjs-boilerplate.png" width=""/>

<img src="https://github.com/kkamara/useful/blob/main/php-reactjs-boilerplate2.png?raw=true" alt="php-reactjs-boilerplate2.png" width=""/>

# PHP Filament App 2



* [Using Thunder Client?](#thunder-client)

* [Installation](#installation)

* [Usage](#usage)

* [API Documentation](#api-documentation)

* [Unit Tests](#unit-tests)

* [Misc](#misc)

* [Contributing](#contributing)

* [License](#license)

<a name="thunder-client"></a>
## Using Thunder Client?

[Thunder client](https://www.thunderclient.com/) Visual Studio Code extension.

## Installation

* [Laravel Herd](https://herd.laravel.com)
* [MySQL (recommended) or database engine of SQLite, MariaDB, PostgreSQL, SQL Server](https://laravel.com/docs/11.x/database#introduction)
* [https://laravel.com/docs/11.x/installation](https://laravel.com/docs/11.x/installation)
* [https://laravel.com/docs/11.x/vite#main-content](https://laravel.com/docs/11.x/vite#main-content)

```bash
# Create our environment file.
cp .env.example .env
# Update database values in .env file.
# Install our app dependencies.
composer i
php artisan key:generate
# Before running the next command:
# Update your database details in .env
php artisan migrate --seed
npm install
npm run build
```

## Usage

```bash
herd link filament2
# Website accessible at http://filament2.test
```

## API Documentation

```bash
php artisan route:list
```

## Unit Tests

```bash
php artisan test --filter=Api
```

## Misc

[See PHP ReactJS Boilerplate app.](https://github.com/kkamara/php-reactjs-boilerplate)

[See Python ReactJS Boilerplate app.](https://github.com/kkamara/python-reactjs-boilerplate)

[See MRVL Desktop.](https://github.com/kkamara/mrvl-desktop)

[See MRVL Web.](https://github.com/kkamara/mrvl-web)

[See Github to Bitbucket Backup Repo Updater.](https://github.com/kkamara/ghbbupdater)

[See PHP Docker Skeleton.](https://github.com/kkamara/php-docker-skeleton)

[See Python Docker Skeleton.](https://github.com/kkamara/python-docker-skeleton)

[See Laravel 10 API 3.](https://github.com/kkamara/laravel-10-api-3)

[See movies app.](https://github.com/kkamara/movies)

[See Food Nutrition Facts Search web app.](https://github.com/kkamara/food-nutrition-facts-search-web-app)

[See Ecommerce Web.](https://github.com/kkamara/ecommerce-web)

[See City Maps Mobile.](https://github.com/kkamara/city-maps-mobile)

[See Ecommerce Mobile.](https://github.com/kkamara/ecommerce-mobile)

[See CRM.](https://github.com/kkamara/crm)

[See Birthday Currency.](https://github.com/kkamara/birthday-currency)

[See PHP Scraper.](https://github.com/kkamara/php-scraper)

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[BSD](https://opensource.org/licenses/BSD-3-Clause)
