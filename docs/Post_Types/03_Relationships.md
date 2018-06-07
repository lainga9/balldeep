The post model has the following relationships available:

```
$post->children
```

returns any children of the post if the post's type is hierarchical - **Collection (of Post models)**

```
$post->taxonomies
```

returns any taxonomies which the post is associated with - **Collection (of Taxonomy models)**

```
$post->metas
```

returns all meta data which has been attached to the post - **Collection (of PostMeta models)**