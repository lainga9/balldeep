Sitemaps are generated using this package

[https://github.com/Laravelium/laravel-sitemap](https://github.com/Laravelium/laravel-sitemap)

Command:

    php artisan balldeep:generate-sitemap {models*}

where models are a list of fully namespaced models which you would like added to the sitemap e.g.

    php artisan balldeep:generate-sitemap App\\Page App\\Post

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