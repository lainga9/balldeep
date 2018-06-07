<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Traits\Sluggable;
use Auth;

class Post extends Model {

	use Sluggable;
	
	/*
	|--------------------------------------------------------------------------
	| Variables
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Table columns which cannot be mass assigned
	 * 
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The name of the table in the DB
	 * 
	 * @var string
	 */
	protected $table = 'bd_posts';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot()
	{
		parent::boot();

		static::updating(function($post)
		{
			if( $post->isDirty('content') )
			{
				$post->revisions()->create([
					'content' => $post->getOriginal('content'),
					'user_id' => Auth::user()->id
				]);
			}
		});

		static::creating(function($post)
		{
			$post->excerpt = property_exists($post, 'excerpt') ?
							$post->excerpt : 
							substr($post->content, 0, 255);
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The user who created the post
	 * 
	 * @return Post
	 */
	public function post()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\Post',
			'user_id'
		);
	}

	/**
	 * The type of the post
	 * 
	 * @return PostType
	 */
	public function type()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\PostType',
			'post_type_id'
		);
	}

	/**
	 * Return any children of the post
	 * 
	 * @return HasMany
	 */
	public function children()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\Post',
			'post_parent_id'
		);
	}

	/**
	 * Return any revisions of the post
	 * 
	 * @return HasMany
	 */
	public function revisions()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\PostRevision',
			'post_id'
		)->latest();
	}

	/**
	 * The taxonomies to which the post belongs
	 * 
	 * @return BelongsToMany
	 */
	public function taxonomies()
	{
		return $this->belongsToMany(
			'Lainga9\BallDeep\app\Taxonomy',
			'bd_post_taxonomy',
			'post_id',
			'taxonomy_id'
		);
	}

	/**
	 * The media item attached to the post
	 * 
	 * @return Media
	 */
	public function media()
	{
		return $this->belongsTo(
			'Lainga9\BallDeep\app\Media',
			'media_id'
		);
	}

	/**
	 * Return all of the related post meta.
	 * Note: using plural form so we can use
	 * the singular as a getter method
	 * 
	 * @return HasMany
	 */
	public function metas()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\PostMeta',
			'post_id'
		);
	}

	/**
	 * Any menu items which are linking to this page
	 * 
	 * @return HasMany
	 */
	public function menuItems()
	{
		return $this->hasMany(
			'Lainga9\BallDeep\app\MenuItem',
			'post_id'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	|
	*/

	public function scopeTopLevel($query)
	{
		return $query->where('post_parent_id', 0);
	}

	public function scopeTaxonomy($query, $taxonomyId = null)
	{
		if( ! $taxonomyId ) return $query;

		return $query->whereHas('taxonomies', function($sub) use ($taxonomyId)
		{
			$sub->where('bd_taxonomies.id', $taxonomyId);
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return the URL to frontend page
	 * 
	 * @return string
	 */
	public function url()
	{
		return route('balldeep.posts.show', [$this->type->slug, $this->slug]);
	}

	/**
	 * Return the title/name of the post
	 * 
	 * @return string
	 */
	public function title()
	{
		return $this->name;
	}

	/**
	 * Return the short version of the content
	 * 
	 * @return string
	 */
	public function excerpt()
	{
		return $this->excerpt;
	}

	/**
	 * Return the content of the post
	 * 
	 * @return string
	 */
	public function content()
	{
		$content = $this->content;

		$codes = preg_match_all('#({(?>[^{}]|(?0))*?})#', $content, $matches);

		if( ! count($matches) ) return $this->content;

		$matches = array_unique(array_flatten($matches));

		foreach( $matches as $match )
		{
			$toReplace = $match;

			$match = str_replace(['{', '}'], '', $match);

			$components = explode(' ', $match);

			$model = sprintf('Lainga9\\BallDeep\\app\\%s', $modelName = ucwords(array_shift($components)));

			if( ! class_exists($model) ) continue;

			if( ! count($components) ) continue;

			foreach( $components as $component )
			{
				$pieces = explode(':', $component);

				$params[$pieces[0]] = $pieces[1];
			}

			if( ! array_key_exists('id', $params) ) continue;

			$title =array_key_exists('title', $params) ? $params['title'] : null;

			$title = $title !== 'false' ? true : false;

			$model = $model::find($id = $params['id']);

			if( ! $model )
			{
				$replace = sprintf('%s with ID %d not found!', $modelName, $id);
			}
			else
			{
				$replace = $model->display($title);
			}

			$content = str_replace($toReplace, $replace, $content);
		}

		return $content;
	}

	/**
	 * Return value of post meta attached to post
	 * 
	 * @param  string $key
	 * @return string
	 */
	public function meta($key)
	{
		$meta = $this->metas()->where('key', $key)->first();

		return $meta ? $meta->value() : '';
	}

	/**
	 * Return the date at which the post was published
	 * 
	 * @param  string $format
	 * @return string
	 */
	public function publishedAt($format = 'dS M y g:ia')
	{
		return $this->created_at->format($format);
	}

	/**
	 * Return the date at which the post was last updated
	 * 
	 * @param  string $format
	 * @return string
	 */
	public function updatedAt($format = 'dS M y g:ia')
	{
		return $this->updated_at->format($format);
	}

	/**
	 * Return URL to be used for sitemap generation
	 * 
	 * @return string
	 */
	public function getSitemapUrl()
	{
		return $this->url();
	}

	/**
	 * Return the SEO title if specified
	 * 
	 * @return string
	 */
	public function metaTitle()
	{
		return $this->meta('meta_title') ?: $this->title();
	}

	/**
	 * Return the SEO description if specified
	 * 
	 * @return string
	 */
	public function metaDescription($length = 230)
	{
		$description = $this->meta('meta_description') ?: $this->excerpt();

		return BallDeep::trimString($description);
	}

	/**
	 * Return the social title if specified
	 * 
	 * @return string
	 */
	public function socialTitle()
	{
		return $this->meta('social_title') ?: $this->metaTitle();
	}

	/**
	 * Return the social description if specified
	 * 
	 * @return string
	 */
	public function socialDescription()
	{
		return $this->meta('social_description') ?: $this->metaDescription();
	}

	/**
	 * Return OG facebook tags for <head>
	 * 
	 * @return string
	 */
	public function facebookMeta()
	{
		return BallDeep::getFacebookMetaTags(
			$this->metaTitle(),
			$this->url(),
			$this->media ?
				$this->media->getFirstMediaUrl() :
				null,
			$this->metaDescription()
		);
	}

	/**
	 * Return OG twitter tags for <head>
	 * 
	 * @return string
	 */
	public function twitterMeta()
	{
		return BallDeep::getTwitterMetaTags(
			$this->metaTitle(),
			$this->media ?
				$this->media->getFirstMediaUrl() :
				null,
			$this->metaDescription()
		);
	}

	/**
	 * Return a template partials for the post
	 * 
	 * @param  string $type the name of the partial
	 * @return string
	 */
	public function template($name)
	{
		if( view()->exists($path = sprintf('%s.%s', str_plural($this->type), $name)) )
		{
			$view = $path;
		}
		elseif( view()->exists($path = sprintf('posts.%s', $name)) )
		{
			$view = $path;
		}
		else
		{
			$view = sprintf('vendor.balldeep.posts.%s', $name);
		}

		if( ! view()->exists($view) ) return sprintf('View %s not found', $view);

		return view($view)->with(['post' => $this, 'type' => $this->type])->render();
	}

	/*
	|--------------------------------------------------------------------------
	| Checks
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Check whether a post is in the given taxonomy
	 * 
	 * @param  Taxonomy $tax
	 * @return boolean
	 */
	public function isInTaxonomy(Taxonomy $tax)
	{
		return $this->taxonomies->contains($tax->id);
	}
}