# Musestore

## Some useful commands

php artisan migrate:fresh --seed
php artisan serve

## Setup

composer install
npm install
php artisan key:generate
cp .env.example .env

## Docker

docker compose up -d --build
docker compose exec php bash
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data database
