<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Taxonomy;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Http\Requests\StoreTaxonomyRequest;

class TaxonomiesController extends Controller {

	/**
	 * Instance of Taxonomy model
	 * 
	 * @var Taxonomy
	 */
	protected $taxonomy;

	/**
	 * Instance of PostType model
	 * 
	 * @var PostType
	 */
	protected $type;

	/**
	 * Constructor method
	 * 
	 * @param Taxonomy     $taxonomy
	 * @param PostType $type
	 */
	public function __construct(Taxonomy $taxonomy, PostType $type)
	{
		$this->taxonomy = $taxonomy;
		$this->type = $type;
	}
	
	public function index(PostType $postType)
	{
		$taxonomies = $postType->taxonomies()->latest()->get();

		return view('balldeep::admin.taxonomies.index', compact('taxonomies') + ['type' => $postType]);
	}

	public function create(PostType $postType)
	{

		return view('balldeep::admin.taxonomies.create', ['type' => $postType]);
	}

	public function store(PostType $postType, StoreTaxonomyRequest $request)
	{
		$taxonomy = $postType->taxonomies()->create($request->all());

		if( $request->ajax() )
		{
			return response()->json(compact('taxonomy'));
		}

		return redirect()->route('balldeep.admin.taxonomies.index', $postType)->with('success', 'Taxonomy successfully added!');
	}

	public function edit(Taxonomy $taxonomy)
	{
		return view('balldeep::admin.taxonomies.edit', compact('taxonomy'));
	}

	public function update(Taxonomy $taxonomy, StoreTaxonomyRequest $request)
	{
		$taxonomy->update($request->all());

		return redirect()->route('balldeep.admin.taxonomies.edit', $taxonomy)->with('success', 'Taxonomy successfully updated!');
	}

	public function delete(Taxonomy $taxonomy)
	{
		$type = $taxonomy->type;

		$taxonomy->delete();

		return redirect()->route('balldeep.admin.posts.index', $type)->with('success', 'Taxonomy successfully deleted');
	}
}