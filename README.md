# InspireMeDaily
InspireMeDaily is a web application where users get an inspirational quote each day.

## Features
* Show random quote to the user
* Give rating to quotes
* Show a listing of quotes rated by the current user
* Show a top 25 listing of quotes rated by all users
* Show a breakdown of votes per rating
* Fetch quotes through [ZenQuotes API](https://zenquotes.io/)

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

## Resources
### Laravel
[Laravel](https://laravel.com/) is a web application framework with expressive, elegant syntax. A web framework provides a structure and starting point for creating your application.

I choose Laravel as backend framework. It is one of the best known PHP frameworks.

### Inertia
[Inertia](https://inertiajs.com/) allows you to create fully client-side rendered, single-page apps, without the complexity that comes with modern SPAs.

Inertia isn't a framework, nor is it a replacement for your existing server-side or client-side frameworks. Rather, it's designed to work with them. Think of Inertia as glue that connects the two. Inertia does this via adapters.

I choose React as frontend framework. That was an extra challenge for me, because my prior frontend experience was during the jquery days.

### Zenquotes API
[Zenquotes.io](https://zenquotes.io/) is a simple API that can be used to fetch quotes from infuential figures throughout history into JSON format.

I choose this because it has a lot of quotes and it was free to use.

### Quote cards
I looked for some fun designs to show the random quote to the user and I choose "Quote cards".

See pen created on CodePen.io. Original URL: [https://codepen.io/MarkBoots/pen/gOvObMp](https://codepen.io/MarkBoots/pen/gOvObMp).

### React progress bar
I used a progress bar React component. Which is found [here](https://github.com/KaterinaLupacheva/react-progress-bar).
