<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Console\DetectsApplicationNamespace;
use Lainga9\BallDeep\app\Http\Requests\StoreUserRequest;
use Silber\Bouncer\Database\Role;

class UsersController extends Controller {

	use DetectsApplicationNamespace;

	/**
	 * Instance of User model
	 * 
	 * @var User
	 */
	protected $user;

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
		$model = '\\' . $this->getAppNamespace() . 'User';

        $this->user = new $model;
        $this->role = $role;
	}

	public function index()
	{
		$users = $this->user->all();

		return view('balldeep::admin.users.index', compact('users'));
	}

	public function create()
	{
		$roles = $this->role->all();

		return view('balldeep::admin.users.create', compact('roles'));
	}

	public function store(StoreUserRequest $request)
	{
		$user = $this->user->create($request->except(['password', 'role']) + ['password' => bcrypt($request->input('password'))]);

		$user->assign($request->get('role'));

		return redirect()->route('balldeep.admin.users.index')->with('success', 'User successfully added');
	}

	public function abilities($userId)
	{
		$user = $this->user->findOrFail($userId);

		return view('balldeep::admin.users.abilities', compact('user'));
	}
}