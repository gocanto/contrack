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

## Postman Collection
You will be able to import the given [postman collection](https://github.com/gocanto/contrack/blob/main/storage/contrack.postman_collection.json) to start testing the API. Otherwise, you can follow the bellow
steps.

## Tenants Resources
###### All
```
GET: http://contrack.local/api/tenants
```
###### Create
```
POST: http://contrack.local/api/tenants

{
    "first_name": "Gustavo",
    "last_name": "Ocanto",
    "phone_number": "+6582929875"
}
```
###### Show
```
GET: http://contrack.local/api/tenants/66fb54d9-b8e1-4ead-8ad7-6c7217cb1ef1
```
###### Update
```
PUT: http://contrack.local/api/tenants/cc40510e-24df-4d71-9436-93ddc07e1e4b
{
    "first_name": "Gus",
    "last_name": "Oca",
    "phone_number": "+658292898987"
}
```
###### Remove
```
DELETE: http://contrack.local/api/tenants/8e2b29a0-7e7c-4e32-9d87-f6aca933517d
```

## Units Resources
###### All
```
GET: http://contrack.local/api/units
```
###### Create
```
POST: http://contrack.local/api/units

{
    "condominium_uuid": "772902d6-1416-4dd6-b9f6-7ac4d069e6b6",
    "block_uuid": "fd30ab26-da72-448c-977e-79dca4de51dc",
    "number": "test-03"
}
```
###### Show
```
GET: http://contrack.local/api/units/79d4cc00-ef87-481f-919c-50a2b843c4bf
```
###### Update
```
PUT: http://contrack.local/api/units/171752b1-9dce-4518-9c95-84892b345fdf
{
    "condominium_uuid": "772902d6-1416-4dd6-b9f6-7ac4d069e6b6",
    "block_uuid": "fd30ab26-da72-448c-977e-79dca4de51dc",
    "number": "test-03"
}
```
###### Remove
```
DELETE: http://contrack.local/api/units/ee37599f-2833-45ea-89de-c68337036751
```
###### Mark As Rented
```
POST: http://contrack.local/api/manage-unit/mark-as-rented/a1534b19-557a-49ab-9d05-7a975b75828a
{
    "tenant_uuid": "73c97fa0-7f4d-4c83-bf39-3dd9ead537cf"
}
```
###### Mark As Available
```
POST: http://contrack.local/api/manage-unit/mark-as-available/a1534b19-557a-49ab-9d05-7a975b75828a
```

## Visitors Resources
###### All
```
GET: http://contrack.local/api/visits
NOTES: The phone number and limit are optionals and allow for filtering the visitors list.
{
    "phone_number": "1-854-676-8073 x6555",
    "limit": 50
}
```
###### Show
```
GET: http://contrack.local/api/visits/a646cc33-8c96-4f1c-880e-001b93cd1afe
```
###### Create
```
POST: http://contrack.local/api/visits
{
    "condominium_uuid": "bc735190-fa5c-402e-a73b-23da77a9b6de",
    "block_uuid": "181eb797-7ee7-4bc2-904d-2c9a1b3e9f34",
    "number": "06-02-01",
    "visitor_first_name": "Gus",
    "visitor_last_name": "Ocan",
    "phone_number": "12345",
    "nric_last_r": "12ddfgdd",
    "block_number": "02",
    "unit_number": "06-02"
}
```
###### Update Capacity
```
PUT: http://contrack.local/api/visits/15715f0d-94df-46b2-86cf-81079f1d8554/update-capacity
```


## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/contrack/blob/main/LICENSE) for more information.


## How can I thank you?
Why not star the github repo and share the link for this repository on Twitter?


Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!

Gustavo Ocanto.
