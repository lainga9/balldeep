<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Post;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Http\Requests\StorePostRequest;
use Lainga9\BallDeep\app\Repositories\UploadsRepository;
use Storage;

class PostsController extends Controller {

	/**
	 * Instance of Post model
	 * 
	 * @var Post
	 */
	protected $post;

	/**
	 * Instance of PostType model
	 * 
	 * @var PostType
	 */
	protected $type;

	/**
	 * Instance of UploadsRepository
	 * 
	 * @var UploadsRepository
	 */
	protected $uploads;

	/**
	 * Constructor method
	 * 
	 * @param Post     $post
	 * @param PostType $type
	 * @param UploadsRepository $uploads
	 */
	public function __construct(Post $post, PostType $type, UploadsRepository $uploads)
	{
		$this->post = $post;
		$this->type = $type;
		$this->uploads = $uploads;
	}
	
	public function index($typeSlug)
	{
		$type = $this->type->findBySlug($typeSlug);

		if( ! $type ) abort(404);

		$posts = $type->posts()->latest()->get();

		return view('balldeep::admin.posts.index', compact('posts', 'type'));
	}

	public function create($typeSlug)
	{
		$type = $this->type->findBySlug($typeSlug);

		if( ! $type ) abort(404);

		return view('balldeep::admin.posts.create', compact('type'));
	}

	public function store(PostType $postType, StorePostRequest $request)
	{
		$post = $postType->posts()->create($request->except('taxonomies', 'image', 'image_remove'));

		if( $request->hasFile('image') )
		{
			$path = $this->uploads->uploadFile($request->file('image'));

			$post->clearMediaCollection('featured');

			$post->addMedia(storage_path('app/public/'.$path))
				->withResponsiveImages()
				->toMediaCollection('featured');
		}

		$post->taxonomies()->attach($request->get('taxonomies'));

		return redirect()->route('balldeep.admin.posts.edit', $post)->with('success', 'Post successfully added!');
	}

	public function edit(Post $post)
	{
		return view('balldeep::admin.posts.edit', compact('post'));
	}

	public function update(Post $post, StorePostRequest $request)
	{
		$post->update($request->except(['taxonomies', 'image', 'image_remove']));

		if( $request->hasFile('image') )
		{
			$path = $this->uploads->uploadFile($request->file('image'));

			$post->clearMediaCollection('featured');

			$post->addMedia(storage_path('app/public/'.$path))
				->withResponsiveImages()
				->toMediaCollection('featured');
		}

		if( $request->has('image_remove') ) $post->clearMediaCollection('featured');

		$post->taxonomies()->sync($request->get('taxonomies'));

		return redirect()->route('balldeep.admin.posts.edit', $post)->with('success', 'Post successfully updated!');
	}

	public function delete(Post $post)
	{
		$type = $post->type;

		$post->delete();

		return redirect()->route('balldeep.admin.posts.index', $type->slug)->with('success', 'Post successfully deleted');
	}
}