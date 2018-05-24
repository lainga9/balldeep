<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Post;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Fields\MetaBoxes;
use Lainga9\BallDeep\app\Http\Requests\StorePostRequest;
use Lainga9\BallDeep\app\Repositories\UploadsRepository;
use Storage;
use Spatie\MediaLibrary\Models\Media;

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
	 * Instance of Media model
	 * 
	 * @var Media
	 */
	protected $media;

	/**
	 * Constructor method
	 * 
	 * @param Post     $post
	 * @param PostType $type
	 * @param UploadsRepository $uploads
	 */
	public function __construct(Post $post, PostType $type, UploadsRepository $uploads, Media $media)
	{
		$this->post = $post;
		$this->type = $type;
		$this->uploads = $uploads;
		$this->media = $media;
	}
	
	public function index(PostType $postType, Request $request)
	{
		$posts = $postType->posts()
					->topLevel()
					->taxonomy($request->get('taxonomy'))
					->visibleTo($request->user())
					->latest()
					->get();

		return view('balldeep::admin.posts.index', compact('posts') + ['type' => $postType]);
	}

	public function create(PostType $postType)
	{
		return view('balldeep::admin.posts.create', ['type' => $postType] + compact('metaBoxes'));
	}

	public function store(PostType $postType, StorePostRequest $request)
	{
		$post = $postType->posts()->create($request->except([
			'taxonomies',
			'image',
			'image_remove',
			'meta'
		]));

		if( ! $request->get('media_id') && $request->hasFile('image') )
		{
			$path = $this->uploads->uploadFile($request->file('image'));

			$media = $post->media()->create([]);

			$media->addMedia(storage_path('app/public/'.$path))
				->withResponsiveImages()
				->toMediaCollection('featured');

			$post->update(['media_id' => $media->id]);
		}

		$post->taxonomies()->attach($request->get('taxonomies'));

		if( count($request->get('meta')) )
		{
			foreach( $request->get('meta') as $key => $value )
			{
				if( $value )
				{
					$post->metas()->create(compact('key', 'value'));
				}
			}
		}

		return redirect()->route('balldeep.admin.posts.edit', $post)->with('success', sprintf('%s successfully added!', ucwords($post->type->name)));
	}

	public function edit(Post $post)
	{
		return view('balldeep::admin.posts.edit', compact('post'));
	}

	public function update(Post $post, StorePostRequest $request)
	{
		$post->update($request->except([
			'taxonomies',
			'image',
			'image_remove',
			'meta'
		]));

		if( ! $request->get('media_id') && $request->hasFile('image') )
		{
			$path = $this->uploads->uploadFile($request->file('image'));

			$media = $post->media()->create([]);

			$media->addMedia(storage_path('app/public/'.$path))
				->withResponsiveImages()
				->toMediaCollection('featured');

			$post->update(['media_id' => $media->id]);
		}

		if( $request->has('image_remove') )
		{
			$post->media->delete();
		}

		if( count($request->get('meta')) )
		{
			foreach( $request->get('meta') as $key => $value )
			{
				if( $value )
				{
					$post->metas()->create(compact('key', 'value'));
				}
			}
		}

		$post->taxonomies()->sync($request->get('taxonomies'));

		return redirect()->route('balldeep.admin.posts.edit', $post)->with('success', sprintf('%s successfully updated!', ucwords($post->type->name)));
	}

	public function delete(Post $post)
	{
		$type = $post->type;

		$post->menuItems()->delete();

		$post->delete();

		return redirect()->route('balldeep.admin.posts.index', $type)->with('success', sprintf('%s successfully deleted!', ucwords($post->type->name)));
	}
}