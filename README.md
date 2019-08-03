<p align="center">
<img style="max-width: 150px;" src="https://upload.wikimedia.org/wikipedia/en/thumb/e/ea/Superman_shield.svg/1200px-Superman_shield.svg.png">
</p>


<h1 align="center">Samirz Super CRUD</h1>

This package allows you to make a CRUD in a one command

## video Tutorial
[https://youtube.com](https://youtube.com)

## Installation

1. first of all add the package to your project with this command:
```
composer require samirz/super
```

2. publish the vendor views
```
php artisan vendor:publish --provider="Samirz\Super\Providers\SuperServiceProvider"
```
1. on web.php file add this route to access the dashboard page
```php
Route::get('/samirz', function() {
    return view('samirz.pages.dashboard');
});
```

now we are ready to use the package commands to create 
- Normal CRUD
- Ajax CRUD
- Api CRUD

## Create Normal CRUD
open the terminal and type this command

```
php artian samirz:super-crud
```
then hit enter and it will ask you about the `Model name` and the `fillable` fill theme and the CRUD will be generated in this structure.

for exmaple you will make a CRUD with model name `Sam` the structure will be like the following:
<br>
after creating the CRUD it will append the routes for you on the correct route file, like wep.php or api.php

```
[app]
  |
  └── Http
  |     └── Controller
  |     |       └── SamController.php
  |     └── Requests
  |             └── SamRequest.php
  └── Models
  |     └── Sam.php
  └── Repositories
  |     └── SamRepository.php
  └── Services
        └── SamService.php

[resources]
  |
  └── views
        └── sams
             └── script
             |      └── index.blade.php [ajax statements]
             |      └── trash.blade.php [ajax statements]
             └── index.blade.php
             └── create.blade.php
             └── show.blade.php
             └── edit.blade.php
             └── trash.blade.php
```

## Create Ajax CRUD
```
php artian samirz:super-crud-ajax
```

the structure is:
```
[app]
  |
  └── Http
  |     └── Controller
  |     |       └── SamController.php
  |     └── Requests
  |             └── SamRequest.php
  └── Models
  |     └── Sam.php
  └── Repositories
  |     └── SamRepository.php
  └── Services
        └── SamService.php

[resources]
  |
  └── views
        └── sams
             └── script
             |      └── index.blade.php [ajax statements]
             |      └── trash.blade.php [ajax statements]
             └── index.blade.php
             └── trash.blade.php
```

## Create Api CRUD
```
php artian samirz:super-crud-api
```

the structure is:
```
[app]
  |
  └── Http
  |     └── Controller
  |     |       └── SamController.php
  |     └── Requests
  |             └── SamRequest.php
  |     └── Resources
  |             └── SamResource.php
  └── Models
  |     └── Sam.php
  └── Repositories
  |     └── SamRepository.php
  └── Services
        └── SamService.php
```

# notes
- you can customize the controllers, services and repositories
- The `normal` controller extends `Samirz\Super\Http\Controllers\NormalController`
- The `ajax` controller extends `Samirz\Super\Http\Controllers\AjaxController`
- The `api` controller extends `Samirz\Super\Http\Controllers\ApiController`
- The `Service class` extends `Samirz\Super\Services\SamirzService`
- The `Repository class` extends `Samirz\Super\Services\SamirzRepository`
- The package give you some helper functions located in helpers directory on the package directory
  - `response.php` contains json response for the controller actions
  - `mix.php` contains various functions
