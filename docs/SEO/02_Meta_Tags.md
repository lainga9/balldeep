#### Adding SEO Meta Fields

Standard SEO meta fields can be added to given post types by using the following command

```
php artisan balldeep:seo-meta {types*}
```

where types are a space-separated list of post type slugs.

This command will attached the following meta fields to the post types specified:

* **Meta Title**
   
   The value which should be passed to the `<title>` tag. Will default to post title if not specified.

* **Meta Description**

   The content to pass to the `<meta name="description">` tag. Will default to post excerpt if not specified.

* **Social Title**

   The title to pass to facebook and twitter meta tags. Will default to the meta title if not specified.

* **Social Description**

   The description to pass to facebook and twitter meta tags. Will default to the meta description if not specified.

The post's featured image will also be added to the facebook and twitter tags by default.

---

#### Outputting Meta

To output the social meta on the frontend you can use the following methods which are defined on the Post model:

```
$post->facebookMeta()
```

and

```
$post->twitterMeta()
```

The meta title and description can be accessed by using:

```
$post->metaTitle()
```

and

```
$post->metaDescription()
```