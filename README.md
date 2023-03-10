# Laravel Booking API

## Installation

Clone the repo locally:

```sh
git clone https://github.com/kamilkozak/booking-api.git
cd booking-api
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Start Sail

```sh
./vendor/bin/sail up -d
```

Run:

```sh
./vendor/bin/sail artisan key:generate
```

Run database migrations with seeders:

```sh
./vendor/bin/sail artisan migrate:fresh --seed
```

Import postman collection from root folder:

```sh
booking api.postman_collection.json
```
