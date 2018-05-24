<?php

namespace Lainga9\BallDeep\app;

class MetaGroup extends Model {

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
	protected $table = 'bd_meta_groups';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The fields belonging to the group
	 * 
	 * @return HasMany
	 */
	public function fields()
	{
		return $this->hasMany('Lainga9\BallDeep\app\MetaField', 'meta_group_id');
	}

	/**
	 * The different post types on which this group should
	 * display
	 * 
	 * @return BelongsToMany
	 */
	public function postTypes()
	{
		return $this->belongsToMany('Lainga9\BallDeep\app\PostType', 'bd_meta_group_post_type', 'meta_group_id', 'post_type_id');
	}
}