<?php

namespace Lainga9\BallDeep\app\Http\Controllers;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Post;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Taxonomy;

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
	 * Constructor method
	 * 
	 * @param Post     $post
	 * @param PostType $type
	 */
	public function __construct(Post $post, PostType $type)
	{
		$this->post = $post;
		$this->type = $type;
	}
	
	/**
	 * Show index page of the given post type e.g. blog index
	 * 
	 * @param  string $typeSlugPlural
	 * @return Response
	 */
	public function index($typeSlugPlural)
	{
		$type = $this->type->findBySlug(str_singular($typeSlugPlural));

		if( ! $type ) abort(404);

		if( view()->exists($path = sprintf('%s.index', $typeSlugPlural)) )
		{
			$view = $path;
		}
		elseif( view()->exists($path = 'posts.index') )
		{
			$view = $path;
		}
		else
		{
			$view = 'vendor.balldeep.posts.index';
		}

		$posts = $type->posts()->latest()->get();

		return view($view, compact('posts', 'type'));
	}

	/**
	 * Show either a single post or a taxonomy index
	 * 
	 * @param  string $routeSlug
	 * @param  string $slug
	 * @return Response
	 */
	public function route($routeSlug, $slug)
	{
		$type = $this->type->findBySlug($routeSlug);

		if( ! $type )
		{
			$type = $this->type->findBySlug(str_singular($routeSlug));
		}

		if( ! $type) abort(404);

		$post = $type->posts()->where('slug', $slug)->first();

		if( $post ) return $this->showPost($type, $post);

		$tax = $type->taxonomies()->where('slug', $slug)->first();

		if( $tax ) return $this->showTaxonomy($type, $tax);

		abort(404);
	}

	/**
	 * Show a single post
	 * 
	 * @param  PostType $type
	 * @param  Post     $post 
	 * @return Response
	 */
	public function showPost(PostType $type, Post $post)
	{
		if( view()->exists($path = sprintf('%s.show', str_plural($type->slug))) )
		{
			$view = $path;
		}
		elseif( view()->exists($path = 'posts.show') )
		{
			$view = $path;
		}
		else
		{
			$view = 'vendor.balldeep.posts.show';
		}

		return view($view, compact('post', 'type'));
	}

	/**
	 * Show a taxonomy index page
	 * 
	 * @param  Taxonomy $tax
	 * @return Response
	 */
	public function showTaxonomy(PostType $type, Taxonomy $tax)
	{
		if( view()->exists($path = sprintf('%s.%s.index', str_plural($type->slug), $tax->slug)) )
		{
			$view = $path;
		}
		elseif( view()->exists($path = sprintf('%s.index', str_plural($type->slug))) )
		{
			$view = $path;
		}
		elseif( view()->exists($path = sprintf('vendor.balldeep.%s.%s.index', str_plural($type->slug), $tax->slug)) )
		{
			$view = $path;
		}
		else
		{
			$view = 'vendor.balldeep.posts.index';
		}

		$posts = $tax->posts;

		return view($view, compact('type', 'tax', 'posts'));
	}
}