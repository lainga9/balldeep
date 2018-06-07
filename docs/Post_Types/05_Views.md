#### Default Views

Views are published to resources/views/vendor/balldeep/ and can be edited here.

---

#### Custom Views

Custom views can be created by adding a directory in your views directory with the plural name of the post type and index.blade.php for the index page and show.blade.php for the single.

For example for a post type with name 'page' you would add:

```
pages/
  |__index.blade.php // Show all pages
  |__show.blade.php // Show single page
```

The index view is passed a Collection of [Post](02_Methods) models and the single view is passed a [Post](02_Methods) model. Both views are passed the PostType model.

Category views can be overridden by adding a folder named the taxonomy name within the corresponding post type folder e.g. /posts/sport/index.blade.php

#### Posts Per Page

By default, 9 posts per page are shown for all post types on the index view but this can be updated by adding an entry to the 'posts_per_page' array in config/balldeep.php. The key should be the singular name of the post type and the value should be the desired number of posts per page.