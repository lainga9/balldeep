<?php

namespace Lainga9\BallDeep\app\Composers;

use Spatie\MediaLibrary\Models\Media;

class MediaGalleryViewComposer {

	public function __construct(Media $media)
	{
		$this->media = $media;
	}

	public function compose($view)
	{
		$view->with(['media' => $this->media->latest()->get()]);
	}

}