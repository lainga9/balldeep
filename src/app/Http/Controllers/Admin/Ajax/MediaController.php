<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin\Ajax;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller {

	protected $media;

	public function __construct(Media $media)
	{
		$this->media = $media;
	}

	public function getGalleryHtml()
	{
		$view = view('balldeep::_partials.media-gallery');

		return response()->json(['html' => $view->render()]);
	}
}