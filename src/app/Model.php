<?php

namespace Lainga9\BallDeep\app;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Model extends EloquentModel implements HasMedia {

	use HasMediaTrait;

	public function registerMediaConversions(Media $media = null)
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

}