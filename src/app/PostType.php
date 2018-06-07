<?php

namespace Lainga9\BallDeep\app;

use Lainga9\BallDeep\app\Traits\Sluggable;

class PostType extends Model {

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
	protected $table = 'bd_post_types';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The posts of this type
	 * 
	 * @return HasMany
	 */
	public function posts()
	{
		return $this->hasMany('Lainga9\BallDeep\app\Post');
	}

	/**
	 * The taxonomies for this post type
	 * 
	 * @return HasMany
	 */
	public function taxonomies()
	{
		return $this->hasMany('Lainga9\BallDeep\app\Taxonomy');
	}

	/**
	 * Any meta groups which should display for this post type
	 * 
	 * @return BelongsToMany
	 */
	public function metaGroups()
	{
		return $this->belongsToMany('Lainga9\BallDeep\app\MetaGroup', 'bd_meta_group_post_type', 'post_type_id', 'meta_group_id');
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return the number of posts which should be displayed
	 * per page on the index view. Can be set in config or 
	 * if not then defaults to 9
	 * 
	 * @return integer
	 */
	public function postsPerPage()
	{
		$config = config('balldeep.posts_per_page');

		$postsPerPage = 9;

		if( is_array($config) && array_key_exists($this->slug, $config) )
		{
			$postsPerPage = $config[$this->slug] ?: $postsPerPage;
		}

		return $postsPerPage;
	}
}