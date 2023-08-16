# API for online painting shop

## How to run?

1. ```git clone https://github.com/wiktorsk8/api-paint-shop.git```
2. ``composer install``
3. fill .env file with your DB details (Docker compose is set for MariaDB)
4. ```php artisan key:generate```
5. ```docker compose up -d```
6. ```php artisan migrate --seed```
7. ```php artisan serve```

### To login as admin use email: admin@admin.com password:123123123

## To clone frontend visit -> https://github.com/nose15/paintings-frontend