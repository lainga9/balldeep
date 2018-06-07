<?php 

return [
    
    /**
     * The name of the layout which should be used
     * for frontend views
     */
    'layout' => env('BD_LAYOUT', 'app'),

    /**
     * The additional image sizes which should be
     * generated when uploading an image
     */
    'image_sizes' => [

    	'thumbnail' => [320, 240],

    ],

    /**
     * URLs for different post types e.g. blog for posts
     */
    'post_type_urls' => [

        'post' => env('BD_POST_URL', null)
    ],

    /**
     * Number of posts per page
     */
    'posts_per_page' => [

        'post' => env('BD_POSTS_PER_PAGE')
    ],

    /**
     * The directory to which we should upload media
     * e.g. uploads/media
     */
    'media_upload_directory' => env('BD_MEDIA_UPLOAD_DIRECTORY', 'uploads/media'),

    /**
     * The prefix for all content routes
     */
    'content_prefix' => env('BD_CONTENT_PREFIX', 'content')

];
