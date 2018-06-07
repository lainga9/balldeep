## General

add

`"lainga9/balldeep": "dev-master"`

for local setup also add

```
"repositories": [
    {
        "type": "path",
        "url": "../packages/lainga9/balldeep/",
        "options": {
            "symlink": true
        }
    }
]
```

and

```
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/",
        "Lainga9\\BallDeep\\": "../packages/lainga9/balldeep/src"
    }
}
```

to composer.json and update

if the requirements cannot be resolved try adding

`"minimum-stability": "dev"` 

to main project's composer.json file

then

```
php artisan package:discover

php artisan vendor:publish --provider="Lainga9\BallDeep\BallDeepServiceProvider" --force

php artisan vendor:publish --tag="bouncer.migrations"

php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"

php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"

php artisan migrate

composer dump-auto

php artisan db:seed --class="BdPostTypesTableSeeder"

php artisan db:seed --class="BdRolesTableSeeder"

php artisan storage:link

```

## User Management

Add

```
'balldeep' => [
    'driver' => 'session',
    'provider' => 'balldeep',
],
```

to guards array and 

```
'balldeep' => [
    'driver' => 'eloquent',
    'model' => Lainga9\BallDeep\app\User::class,
],
```

to providers array in config/auth.php.

## Setup

To run setup you can optionally run

```
php artisan balldeep:setup
```

Add facade to config/app.php

Add styles to layout

`BallDeep::styles()`

## Media Manager

https://github.com/spatie/laravel-medialibrary

Update config/medialibrary.php to use correct S3 bucket

Also add in path to custom MediaPathGenerator.php class


## Menu Manager