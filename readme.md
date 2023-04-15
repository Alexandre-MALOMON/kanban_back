## requirement

PHP 7.4
Composer 2.0.2
Laravel 8

## Clone the repository

git clone https://git@github.com:Alexandre-MALOMON/kanban_back.git

Switch to the repo folder

cd kanban_back

Install all the dependencies using composer

composer install

Copy the example env file and make the required configuration changes in the .env file

cp .env.example .env

Generate a new application key

php artisan key:generate

php artisan migrate

Start the local development server

php artisan serve

You can now access the server at http://localhost:8000

## Database seeding

Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.

Open the DummyDataSeeder and set the property values as per your requirement

database/seeds/DummyDataSeeder.php

Run the database seeder and you're done

php artisan db:seed

Note : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

php artisan migrate:refresh
