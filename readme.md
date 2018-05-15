## User Management



## Roles and Permissions

https://github.com/JosephSilber/bouncer

Add to User model

```
use Silber\Bouncer\Database\HasRolesAndAbilities;
```

`php artisan vendor:publish --tag="bouncer.migrations"`

## Sitemaps

Sitemaps are generated using this package

[https://github.com/Laravelium/laravel-sitemap](https://github.com/Laravelium/laravel-sitemap)

Command - balldeep:generate-sitemap {models*}

where models are a list of fully namespaced models which you would like added to the sitemap e.g.

```balldeep:generate-sitemap App\\Page App\\Post```

**Setup**

Define a method on the required models as follows:

```
public function getSitemapUrl()
{
	// Return the URL which should be added to the sitemap
	return $this->url;
}
```

An updated_at timestamp column in the model's table is also required.

## Media Manager

https://github.com/spatie/laravel-medialibrary

```php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"```

```php artisan migrate```

```php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"```


## Menu Manager

https://github.com/taye/interact.js

`sudo npm install interactjs --save`

## Content Manager

`php artisan db:seed --class="BdPostTypesTableSeeder";`

Comes with default post types: page and post

A route with the plural of any post type is added automatically e.g.

site.test/content/posts

Views are published to vendor/balldeep/ and can be edited here.

Or, you can add a directory in your views directory with the plural name of the post type and index.blade.php for the index page and show.blade.php for the single

The index view is passed a Collection and the single view is passed a Model. Both views are passed the post type model.

Category views can be overridden by adding a folder named the taxonomy name within the corresponding post type folder e.g. /posts/sport/index.blade.php