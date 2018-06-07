A route with the plural of any post type is added automatically e.g.

**site.test/content/posts**

The prefix 'content' can be changed by updating the 'content_prefix' config value in config/balldeep.php.

If you would like to have a unique route for the post type index then you can add an entry to the 'post_type_urls' array in config/balldeep.php. 

So, for example, to add a blog/ url you could add

```
'post_type_urls' => [
   'post' => 'blog'
]
```
