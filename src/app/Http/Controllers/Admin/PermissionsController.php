<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Lainga9\BallDeep\app\Http\Requests\StoreRoleRequest;
use Silber\Bouncer\Database\Permission;

class PermissionsController extends Controller {

	/**
	 * Instance of Role model
	 * 
	 * @var Role
	 */
	protected $role;

	/**
	 * Constructor method
	 */
	public function __construct(Role $role)
	{
		$this->role = $role;
	}

	public function index()
	{
		$roles = $this->role->all();

		return view('balldeep::admin.roles.index', compact('roles'));
	}

	public function create()
	{
		return view('balldeep::admin.roles.create');
	}

	public function store(StoreRoleRequest $request)
	{
		$role = $this->role->create($request->all());

		return redirect()->route('balldeep.admin.roles.index')->with('success', 'Role successfully stored!');
	}
}