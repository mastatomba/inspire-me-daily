# InspireMeDaily
InspireMeDaily is a web application where users get an inspirational quote each day.

## Installation
Clone the repo locally:
```
git clone https://github.com/mastatomba/inspire-me-daily.git
cd inspire-me-daily
```

Install PHP dependencies:
```
composer install
```

Install NPM dependencies:
```
npm install
```

Build assets:
```
npm run dev
```

Setup configuration:
```
cp .env.example .env
```

Generate application key:
```
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.
```
touch database/database.sqlite
```

Run database migrations:
```
php artisan migrate
```

Run database seeder:
```
php artisan db:seed
```

Run artisan server:
```
php artisan serve
```

Visit InspireMeDaily in your browser (http://127.0.0.1:8000), and login with:
- Username: `mahatma@gandhi.com`
- Password: `secret-pw`


## Running tests
To run the InspireMeDaily tests, run:
```
php artisan test
```
