<?php

/**
 * Frontend post routes
 */
app('router')->group([
	'prefix' => 'content',
	'namespace' => '\Lainga9\BallDeep\app\Http\Controllers',
	'middleware' => ['web', 'bindings']
], function()
{
	app('router')->get('{typeSlugPlural}', [
		'as'	=> 'balldeep.posts.index',
		'uses'	=> 'PostsController@index'
	]);

	app('router')->get('{typeSlug}/{slug}', [
		'as'	=> 'balldeep.posts.show',
		'uses'	=> 'PostsController@route'
	]);
});

/**
 * Backend routes
 */
app('router')->group([
	'prefix' => 'manage', 
	'namespace' => '\Lainga9\BallDeep\app\Http\Controllers\Admin',
	'middleware' => ['web', 'bindings']
], function()
{
	app('router')->get('/', [
		'as'	=> 'balldeep.admin.index',
		'uses'	=> 'BaseController@index'
	]);

	/**
	 * User management
	 */
	app('router')->group(['prefix' => 'users'], function()
	{
		
	});

	/**
	 * Content Management
	 */
	app('router')->group(['prefix' => 'content'], function()
	{
		app('router')->get('{type}', [
			'as'	=> 'balldeep.admin.posts.index',
			'uses'	=> 'PostsController@index'
		]);

		app('router')->get('create/{type}', [
			'as'	=> 'balldeep.admin.posts.create',
			'uses'	=> 'PostsController@create'
		]);

		app('router')->post('create/{postType}', [
			'as'	=> 'balldeep.admin.posts.store',
			'uses'	=> 'PostsController@store'
		]);

		app('router')->get('edit/{post}', [
			'as'	=> 'balldeep.admin.posts.edit',
			'uses'	=> 'PostsController@edit'
		]);

		app('router')->put('edit/{post}', [
			'as'	=> 'balldeep.admin.posts.update',
			'uses'	=> 'PostsController@update'
		]);

		app('router')->delete('delete/{post}', [
			'as'	=> 'balldeep.admin.posts.delete',
			'uses'	=> 'PostsController@delete'
		]);

		/**
		 * Taxonomy Management
		 */
		app('router')->group(['prefix' => 'taxonomies'], function()
		{
			app('router')->get('{type}', [
				'as'	=> 'balldeep.admin.taxonomies.index',
				'uses'	=> 'TaxonomiesController@index'
			]);

			app('router')->get('create/{type}', [
				'as'	=> 'balldeep.admin.taxonomies.create',
				'uses'	=> 'TaxonomiesController@create'
			]);

			app('router')->post('create/{postType}', [
				'as'	=> 'balldeep.admin.taxonomies.store',
				'uses'	=> 'TaxonomiesController@store'
			]);

			app('router')->get('edit/{taxonomy}', [
				'as'	=> 'balldeep.admin.taxonomies.edit',
				'uses'	=> 'TaxonomiesController@edit'
			]);

			app('router')->put('edit/{taxonomy}', [
				'as'	=> 'balldeep.admin.taxonomies.update',
				'uses'	=> 'TaxonomiesController@update'
			]);

			app('router')->delete('delete/{taxonomy}', [
				'as'	=> 'balldeep.admin.taxonomies.delete',
				'uses'	=> 'TaxonomiesController@delete'
			]);
		});
	});

	/**
	 * Media Management
	 */
	app('router')->group(['prefix' => 'media'], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.media.index',
			'uses'	=> 'MediaController@index'
		]);

		app('router')->delete('{media}', [
			'as'	=> 'balldeep.admin.media.delete',
			'uses'	=> 'MediaController@delete'
		]);
	});

	/**
	 * Menu Management
	 */
	app('router')->group(['prefix' => 'menu'], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.menu.index',
			'uses'	=> 'MenuController@index'
		]);

		app('router')->get('create', [
			'as'	=> 'balldeep.admin.menu.create',
			'uses'	=> 'MenuController@create'
		]);

		app('router')->post('create', [
			'as'	=> 'balldeep.admin.menu.store',
			'uses'	=> 'MenuController@store'
		]);

		app('router')->delete('delete/{menu}', [
			'as'	=> 'balldeep.admin.menu.delete',
			'uses'	=> 'MenuController@delete'
		]);

		app('router')->get('manage/{menu}', [
			'as'	=> 'balldeep.admin.menu.manage',
			'uses'	=> 'MenuController@manage'
		]);

		app('router')->post('reorder/{menu}', [
			'as'	=> 'balldeep.admin.menu.reorder',
			'uses'	=> 'MenuController@reorder'
		]);

		app('router')->group(['prefix' => 'items'], function()
		{
			app('router')->post('create/{menu}', [
				'as'	=> 'balldeep.admin.menu.items.store',
				'uses'	=> 'MenuItemsController@store'
			]);
		});
	});
});