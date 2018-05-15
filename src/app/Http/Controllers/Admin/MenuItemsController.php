<?php

namespace Lainga9\BallDeep\app\Http\Controllers\Admin;

use Lainga9\BallDeep\app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lainga9\BallDeep\app\Menu;
use Lainga9\BallDeep\app\MenuItem;
use Lainga9\BallDeep\app\Http\Requests\StoreMenuItemRequest;

class MenuItemsController extends Controller {

	protected $menu;

	public function __construct(Menu $menu)
	{
		$this->menu = $menu;
	}

	public function store(Menu $menu, StoreMenuItemRequest $request)
	{
		$item = $menu->items()->create($request->all());

		return redirect()->route('balldeep.admin.menu.manage', $menu)->with('success', 'Menu successfully updated!');
	}

}