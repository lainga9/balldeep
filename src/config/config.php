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

    ]

];
