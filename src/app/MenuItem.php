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
				'bd_menu_id' => $item->bd_menu_id]
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
		return $this->belongsTo('Lainga9\BallDeep\app\MenuItem');
	}
}