<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller {

	protected $media;

	public function __construct(Media $media)
	{
		$this->media = $media;
	}

	public function index()
	{
		$media = $this->media->all();

		return view('balldeep::admin.media.index', compact('media'));
	}

	public function delete(Media $media)
	{
		$media->model()->delete();

		$media->delete();

		return redirect()->back()->with('success', 'Media successfully deleted');
	}
}