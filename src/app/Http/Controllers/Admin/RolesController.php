<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Lainga9\BallDeep\app\Http\Requests\StoreRoleRequest;
use Silber\Bouncer\Bouncer;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;

class RolesController extends Controller {

	/**
	 * Instance of Role model
	 * 
	 * @var Role
	 */
	protected $role;

	/**
	 * Instance of Ability model
	 * 
	 * @var Ability
	 */
	protected $ability;

	/**
	 * Constructor method
	 */
	public function __construct(Role $role, Ability $ability, Bouncer $bouncer)
	{
		$this->role = $role;
		$this->ability = $ability;
		$this->bouncer = $bouncer;
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

	public function edit(Role $role)
	{
		$abilities = $this->ability->orderBy('name')->get();

		return view('balldeep::admin.roles.edit', compact('role', 'abilities'));	
	}

	public function update(StoreRoleRequest $request, Role $role)
	{
		$role->update($request->except(['abilities']));

		if( count($abilities = $request->get('abilities')) )
		{
			$this->bouncer->sync($role)->abilities($request->get('abilities'));
		}

		return view('balldeep::admin.roles.edit', compact('role'))->with('success', 'Role successfully updated!');
	}
}