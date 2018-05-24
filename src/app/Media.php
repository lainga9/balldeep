<?php

namespace Lainga9\BallDeep\app;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends Model implements HasMedia {

	use HasMediaTrait;

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
	protected $table = 'bd_media';

	/*
	|--------------------------------------------------------------------------
	| Startup
	|--------------------------------------------------------------------------
	|
	*/

	public function registerMediaConversions(SpatieMedia $media = null)
	{
		$sizes = config('balldeep.image_sizes');

		foreach( $sizes as $name => $size )
		{
			$this->addMediaConversion($name)
				->performOnCollections('featured')
				->width($size[0])
				->height($size[1]);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * The posts to which the media item is attached
	 * 
	 * @return HasMany
	 */
	public function posts()
	{
		return $this->hasMany('Lainga9\BallDeep\app\Post');
	}
}