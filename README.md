## Installation

This project uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you 
have it installed in your machine. Once you have done this, you will be able to clone and install this project by 
following the bellow steps within your command line. 

1 - `git@github.com:gocanto/contrack.git`

2 - CD into the project folder. Like so: `cd /contrack` 

3 - Create your environment file. Like so: `cp .env.example .env`. Once you have done this, you will have to update the 
new file with your (DB MYSQL) credentials: Like so: 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contrack
DB_USERNAME=root
DB_PASSWORD=root
```
 
4 - Run composer install. Like so: `composer install`

5 - Create the application encryption key. Like so: `php artisan key:generate`

6 - Run the migrations and DB seeders: Like so: `php artisan migrate:fresh --seed`

7 - Start testing the API endpoints.
