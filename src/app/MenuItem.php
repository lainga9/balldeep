<?php

namespace Lainga9\BallDeep\app;

class MenuItem extends Model {

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
	protected $table = 'bd_menu_items';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public static function boot()
	{
		parent::boot();

		static::creating(function($item)
		{
			$item->order = self::where([
				'menu_id' => $item->menu_id]
			)->max('order') + 1;
		});
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The menu to which the item belongs
	 * 
	 * @return HasMany
	 */
	public function menu()
	{
		return $this->belongsTo('Lainga9\BallDeep\app\Menu', 'menu_id');
	}

	/**
	 * The post to which the menu item should post
	 * 
	 * @return Post
	 */
	public function post()
	{
		return $this->belongsTo('Lainga9\BallDeep\app\Post', 'post_id');
	}

	/**
	 * Return any children of the menu item
	 * 
	 * @return HasMany
	 */
	public function children()
	{
		return $this->hasMany('Lainga9\BallDeep\app\MenuItem', 'parent');
	}

	/*
	|--------------------------------------------------------------------------
	| Scopes
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return top level menu items
	 * 
	 * @param  Builder $query
	 * @return Builder
	 */
	public function scopeTopLevel($query)
	{
		return $query->where('parent', 0);
	}

	/*
	|--------------------------------------------------------------------------
	| Getters & Setters
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Return the label for the menu item
	 * 
	 * @return string
	 */
	public function label()
	{
		return $this->post ? $this->post->title() : $this->label;
	}

	/**
	 * Return the url to which the menu item should point
	 * 
	 * @return string
	 */
	public function url()
	{
		return $this->post ? $this->post->url() : $this->url;
	}
}