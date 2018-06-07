Add

`"lainga9/balldeep": "dev-master"`

to composer.json

For local setup also add

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

to composer.json and run `composer update`

if the requirements cannot be resolved try adding

`"minimum-stability": "dev"` 

to main project's composer.json file.

After installation is complete, run the following:

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

Add 

```Lainga9\BallDeep\app\BallDeep::class```

to aliases array in config/app.php

Add styles to head of main project's layout file

```BallDeep::styles()```