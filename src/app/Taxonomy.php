<?php

namespace Lainga9\BallDeep\app;

use Illuminate\Database\Eloquent\Model;
use Lainga9\BallDeep\app\Traits\Sluggable;

class Taxonomy extends Model {

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
	protected $table = 'bd_taxonomies';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The post type to which the taxonomy belongs
	 * 
	 * @return PostType
	 */
	public function type()
	{
		return $this->belongsTo('Lainga9\BallDeep\app\PostType', 'post_type_id');
	}

	/**
	 * The posts in this taxonomy
	 * 
	 * @return BelongsToMany
	 */
	public function posts()
	{
		return $this->belongsToMany(
			'Lainga9\BallDeep\app\Post',
			'bd_post_taxonomy'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	public function link()
	{
		return route('balldeep.posts.show', [$this->type->slug, $this->slug]);
	} 
}