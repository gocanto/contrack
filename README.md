## Contrack

Contrack is a simple visitor logs system for a condominium manager.

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

## Overview

The whole app is built in a multi-tenant setup where Blocks, Units, Units Tenants and Visitors are scoped by a unique
condominium facility. 

For a better understanding of the models relations, you can click the following links to see the 
[tests](https://github.com/gocanto/contrack/blob/main/tests/Feature/CondominiumTest.php#L22) and the 
[db seeder](https://github.com/gocanto/contrack/blob/main/database/seeders/DatabaseSeeder.php). 

***Note:*** You will be able to see the initial testing data after running the step 7 from installation guide.


## API resources

```
+--------+----------+------------------------------------------+------+-----------------------------------------------------------------+------------+
| Domain | Method   | URI                                      | Name | Action                                                          | Middleware |
+--------+----------+------------------------------------------+------+-----------------------------------------------------------------+------------+
|        | POST     | api/manage-unit/mark-as-available/{uuid} |      | App\Http\Controllers\Units\ManageUnitController@markAsAvailable | api        |
|        | POST     | api/manage-unit/mark-as-rented/{uuid}    |      | App\Http\Controllers\Units\ManageUnitController@markAsRented    | api        |
|        | GET|HEAD | api/tenants                              |      | App\Http\Controllers\Tenants\AllTenantsController               | api        |
|        | POST     | api/tenants                              |      | App\Http\Controllers\Tenants\StoreTenantController              | api        |
|        | GET|HEAD | api/tenants/{uuid}                       |      | App\Http\Controllers\Tenants\ShowTenantController               | api        |
|        | PUT      | api/tenants/{uuid}                       |      | App\Http\Controllers\Tenants\UpdateTenantController             | api        |
|        | DELETE   | api/tenants/{uuid}                       |      | App\Http\Controllers\Tenants\DestroyTenantController            | api        |
|        | GET|HEAD | api/units                                |      | App\Http\Controllers\Units\AllUnitsController                   | api        |
|        | POST     | api/units                                |      | App\Http\Controllers\Units\StoreUnitController                  | api        |
|        | GET|HEAD | api/units/{uuid}                         |      | App\Http\Controllers\Units\ShowUnitController                   | api        |
|        | PUT      | api/units/{uuid}                         |      | App\Http\Controllers\Units\UpdateUnitController                 | api        |
|        | DELETE   | api/units/{uuid}                         |      | App\Http\Controllers\Units\DestroyUnitController                | api        |
|        | GET|HEAD | api/visits                               |      | App\Http\Controllers\Visits\AllVisitsController                 | api        |
|        | POST     | api/visits                               |      | App\Http\Controllers\Visits\StoreVisitController                | api        |
|        | GET|HEAD | api/visits/{uuid}                        |      | App\Http\Controllers\Visits\ShowVisitController                 | api        |
|        | PUT      | api/visits/{uuid}/update-capacity        |      | App\Http\Controllers\Visits\UpdateVisitCapacityController       | api        |
+--------+----------+------------------------------------------+------+-----------------------------------------------------------------+------------+
```
