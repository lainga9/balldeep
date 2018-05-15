<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Lainga9\BallDeep\app\PostType;

class BaseController extends Controller {

	/**
	 * Instance of PostType model
	 * 
	 * @var PostType
	 */
	protected $type;


	public function __construct(PostType $type)
	{
		$this->type = $type;
	}

	public function index()
	{
		$types = $this->type->all();

		return view('balldeep::admin.index', compact('types'));
	}

}