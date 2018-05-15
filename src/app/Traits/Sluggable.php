<?php

namespace Lainga9\BallDeep\app\Traits;

use Cviebrock\EloquentSluggable\Sluggable as CviebrockSluggable;

trait Sluggable {

	use CviebrockSluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Find a model by slug
     * 
     * @param  string $slug
     * @return Model
     */
    public static function findBySlug($slug)
    {
    	return self::where('slug', $slug)->first();
    }
	
}