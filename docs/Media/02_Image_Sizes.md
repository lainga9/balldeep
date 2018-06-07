When uploading an image, extra image sizes can optionally be generated. This is handy for things like thumbnails etc.

These sizes are defined in config/balldeep.php in the 'image_sizes' array.

The key of the entry should be the name of the image size and the value should be an array of width and then height.

For example,

```
'image_sizes' => [

   'banner' => [648, 60]
]
```

By default, a thumbnail image is generated with dimensions 320x240.