<?php

namespace Lainga9\BallDeep\app;

use Illuminate\Database\Eloquent\Model;
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
}