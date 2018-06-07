<?php

/**
 * Frontend post/content routes
 */
app('router')->group([
	'prefix' => config('balldeep.content_prefix'),
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
 * Any post type index routes defined by user
 * e.g 'blog' for posts etc
 */
$urls = config('balldeep.post_type_urls');

if( count($urls) )
{
	foreach( $urls as $type => $url )
	{
		app('router')->get($url, [
			'as'	=> 'balldeep.blog',
			'uses'	=> '\Lainga9\BallDeep\app\Http\Controllers\PostsController@type'
		]);
	}
}

/**
 * Authentication routes
 */
app('router')->group([
	'prefix' => 'manage/auth',
	'namespace' => '\Lainga9\BallDeep\app\Http\Controllers\Auth',
	'middleware' => ['web', 'bindings']
], function()
{
	app('router')->get('login', [
		'as'	=> 'balldeep.login',
		'uses'	=> 'LoginController@showLoginForm'
	]);

	app('router')->get('logout', [
		'as'	=> 'balldeep.logout',
		'uses'	=> 'LoginController@logout'
	]);

	app('router')->post('login', [
		'as'	=> 'balldeep.login.do',
		'uses'	=> 'LoginController@login'
	]);
});


/**
 * Frontend non-content routes
 */
app('router')->group([
	'prefix' => 'balldeep',
	'namespace' => '\Lainga9\BallDeep\app\Http\Controllers',
	'middleware' => ['web', 'bindings']
], function()
{
	app('router')->post('forms/submit/{form}', [
		'as'	=> 'balldeep.forms.submit',
		'uses'	=> 'FormsController@submit'
	]);
});

/**
 * Backend routes
 */
app('router')->group([
	'prefix' => 'manage', 
	'namespace' => '\Lainga9\BallDeep\app\Http\Controllers\Admin',
	'guard' => 'balldeep',
	'middleware' => ['web', 'bindings', \Lainga9\BallDeep\app\Http\Middleware\CheckUserIsBallDeep::class]
], function()
{
	app('router')->get('/', [
		'as'	=> 'balldeep.admin.index',
		'uses'	=> 'BaseController@index'
	]);

	/**
	 * Settings Routes
	 */
	app('router')->group(['prefix' => 'settings', 'middleware' => 'can:manage-settings'], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.settings.index',
			'uses'	=> 'SettingsController@index'
		]);

		app('router')->post('/', [
			'as'	=> 'balldeep.admin.settings.update',
			'uses'	=> 'SettingsController@update'
		]);
	});

	/**
	 * Ajax routes
	 */
	app('router')->group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function()
	{
		app('router')->get('media/gallery', [
			'as'	=> 'balldeep.admin.ajax.media-gallery',
			'uses'	=> 'MediaController@getGalleryHtml'
		]);

		app('router')->get('field/create', [
			'as'	=> 'balldeep.admin.ajax.field.create',
			'uses'	=> 'UtilitiesController@getCreateFieldHtml'
		]);

		/**
		 * Convert a string to one which is suitable for 
		 * input names e.g. alpha_numeric_underscore
		 */
		app('router')->get('strings/slug', [
			'as'	=> 'balldeep.admin.ajax.utilities.input.name.generate',
			'uses'	=> 'UtilitiesController@generateInputName'
		]);
	});

	/**
	 * Form routes
	 */
	app('router')->group(['prefix' => 'forms', 'middleware' => 'can:manage-forms'], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.forms.index',
			'uses'	=> 'FormsController@index'
		]);

		app('router')->get('create', [
			'as'	=> 'balldeep.admin.forms.create',
			'uses'	=> 'FormsController@create'
		]);

		app('router')->post('create', [
			'as'	=> 'balldeep.admin.forms.store',
			'uses'	=> 'FormsController@store'
		]);

		app('router')->get('entries/{form}', [
			'as'	=> 'balldeep.admin.forms.entries',
			'uses'	=> 'FormsController@entries'
		]);

		app('router')->get('entry/{entry}', [
			'as'	=> 'balldeep.admin.forms.entries.show',
			'uses'	=> 'FormEntriesController@show'
		]);

		app('router')->get('edit/{form}', [
			'as'	=> 'balldeep.admin.forms.edit',
			'uses'	=> 'FormsController@edit'
		]);

		app('router')->put('edit/{form}', [
			'as'	=> 'balldeep.admin.forms.update',
			'uses'	=> 'FormsController@update'
		]);

		/**
		 * Form notification routes
		 */
		app('router')->group(['prefix' => 'notifications'], function()
		{
			app('router')->get('{form}', [
				'as'	=> 'balldeep.admin.forms.notifications.index',
				'uses'	=> 'FormsController@notifications'
			]);

			app('router')->get('create/{form}', [
				'as'	=> 'balldeep.admin.forms.notifications.create',
				'uses'	=> 'FormNotificationsController@create'
			]);

			app('router')->post('create/{form}', [
				'as'	=> 'balldeep.admin.forms.notifications.store',
				'uses'	=> 'FormNotificationsController@store'
			]);

			app('router')->get('edit/{notification}', [
				'as'	=> 'balldeep.admin.forms.notifications.edit',
				'uses'	=> 'FormNotificationsController@edit'
			]);

			app('router')->put('edit/{notification}', [
				'as'	=> 'balldeep.admin.forms.notifications.update',
				'uses'	=> 'FormNotificationsController@update'
			]);
		});

		/**
		 * Form Field Routes
		 */
		app('router')->group(['prefix' => 'fields'], function()
		{
			app('router')->post('add/{form}', [
				'as'	=> 'balldeep.admin.forms.fields.add',
				'uses'	=> 'FormsController@addField'
			]);

			app('router')->post('reorder/{form}', [
				'as'	=> 'balldeep.admin.forms.fields.reorder',
				'uses'	=> 'FormsController@reorderFields'
			]);

			app('router')->delete('delete/{field}', [
				'as'	=> 'balldeep.admin.forms.fields.delete',
				'uses'	=> 'FormFieldsController@delete'
			]);
		});
	});

	/**
	 * User management
	 */
	app('router')->group(['prefix' => 'users', 'middleware' => ['can:manage-users']], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.users.index',
			'uses'	=> 'UsersController@index'
		]);

		app('router')->get('create', [
			'as'	=> 'balldeep.admin.users.create',
			'uses'	=> 'UsersController@create'
		]);

		app('router')->post('create', [
			'as'	=> 'balldeep.admin.users.store',
			'uses'	=> 'UsersController@store'
		]);

		app('router')->get('abilities/{user}', [
			'as'	=> 'balldeep.admin.users.abilities',
			'uses'	=> 'UsersController@abilities'
		]);
	});

	/**
	 * Roles management
	 */
	app('router')->group(['prefix' => 'roles', 'middleware' => ['can:manage-users']], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.roles.index',
			'uses'	=> 'RolesController@index'
		]);

		app('router')->get('create', [
			'as'	=> 'balldeep.admin.roles.create',
			'uses'	=> 'RolesController@create'
		]);

		app('router')->post('create', [
			'as'	=> 'balldeep.admin.roles.store',
			'uses'	=> 'RolesController@store'
		]);

		app('router')->get('edit/{role}', [
			'as'	=> 'balldeep.admin.roles.edit',
			'uses'	=> 'RolesController@edit'
		]);

		app('router')->put('edit/{role}', [
			'as'	=> 'balldeep.admin.roles.update',
			'uses'	=> 'RolesController@update'
		]);
	});

	/**
	 * Content Management
	 */
	app('router')->group(['prefix' => 'content'], function()
	{
		/**
		 * Custom Meta Fields
		 */
		app('router')->group(['prefix' => 'fields'], function()
		{
			app('router')->get('/', [
				'as'	=> 'balldeep.admin.groups.index',
				'uses'	=> 'MetaGroupsController@index'
			]);

			app('router')->get('create', [
				'as'	=> 'balldeep.admin.groups.create',
				'uses'	=> 'MetaGroupsController@create'
			]);

			app('router')->post('create', [
				'as'	=> 'balldeep.admin.groups.store',
				'uses'	=> 'MetaGroupsController@store'
			]);

			app('router')->get('edit/{group}', [
				'as'	=> 'balldeep.admin.groups.edit',
				'uses'	=> 'MetaGroupsController@edit'
			]);

			app('router')->put('edit/{group}', [
				'as'	=> 'balldeep.admin.groups.update',
				'uses'	=> 'MetaGroupsController@update'
			]);

			app('router')->delete('delete/{group}', [
				'as'	=> 'balldeep.admin.groups.delete',
				'uses'	=> 'MetaGroupsController@delete'
			]);

			app('router')->post('fields/add/{group}', [
				'as'	=> 'balldeep.admin.groups.fields.add',
				'uses'	=> 'MetaGroupsController@addField'
			]);

			app('router')->post('fields/reorder/{group}', [
				'as'	=> 'balldeep.admin.groups.fields.reorder',
				'uses'	=> 'MetaGroupsController@reorderFields'
			]);
		});

		app('router')->get('{postType}', [
			'as'			=> 'balldeep.admin.posts.index',
			'uses'			=> 'PostsController@index',
			'middleware'	=> ['can:browse,postType']
		]);

		app('router')->get('create/{postType}', [
			'as'			=> 'balldeep.admin.posts.create',
			'uses'			=> 'PostsController@create',
			'middleware'	=> ['can:create,postType']
		]);

		app('router')->post('create/{postType}', [
			'as'			=> 'balldeep.admin.posts.store',
			'uses'			=> 'PostsController@store',
			'middleware'	=> ['can:create,postType']
		]);

		app('router')->get('edit/{post}', [
			'as'			=> 'balldeep.admin.posts.edit',
			'uses'			=> 'PostsController@edit',
			'middleware'	=> ['can:edit,post']
		]);

		app('router')->put('edit/{post}', [
			'as'			=> 'balldeep.admin.posts.update',
			'uses'			=> 'PostsController@update',
			'middleware'	=> ['can:edit,post']
		]);

		app('router')->delete('delete/{post}', [
			'as'			=> 'balldeep.admin.posts.delete',
			'uses'			=> 'PostsController@delete',
			'middleware'	=> ['can:delete,post']
		]);

		/**
		 * Taxonomy Management
		 */
		app('router')->group(['prefix' => 'taxonomies'], function()
		{
			app('router')->get('{postType}', [
				'as'			=> 'balldeep.admin.taxonomies.index',
				'uses'			=> 'TaxonomiesController@index',
				'middleware'	=> ['can:browse,postType']
			]);

			app('router')->get('create/{postType}', [
				'as'			=> 'balldeep.admin.taxonomies.create',
				'uses'			=> 'TaxonomiesController@create',
				'middleware'	=> ['can:create,postType']
			]);

			app('router')->post('create/{postType}', [
				'as'			=> 'balldeep.admin.taxonomies.store',
				'uses'			=> 'TaxonomiesController@store',
				'middleware'	=> ['can:create,postType']
			]);

			app('router')->get('edit/{taxonomy}', [
				'as'			=> 'balldeep.admin.taxonomies.edit',
				'uses'			=> 'TaxonomiesController@edit'
			]);

			app('router')->put('edit/{taxonomy}', [
				'as'			=> 'balldeep.admin.taxonomies.update',
				'uses'			=> 'TaxonomiesController@update'
			]);

			app('router')->delete('delete/{taxonomy}', [
				'as'			=> 'balldeep.admin.taxonomies.delete',
				'uses'			=> 'TaxonomiesController@delete'
			]);
		});
	});

	/**
	 * Media Management
	 */
	app('router')->group(['prefix' => 'media', 'middleware' => 'can:manage-media'], function()
	{
		app('router')->get('/', [
			'as'	=> 'balldeep.admin.media.index',
			'uses'	=> 'MediaController@index'
		]);

		app('router')->get('details/{media}', [
			'as'	=> 'balldeep.admin.media.show',
			'uses'	=> 'MediaController@show'
		]);

		app('router')->delete('{media}', [
			'as'	=> 'balldeep.admin.media.delete',
			'uses'	=> 'MediaController@delete'
		]);
	});

	/**
	 * Menu Management
	 */
	app('router')->group(['prefix' => 'menu', 'middleware' => ['can:manage-menus']], function()
	{
		app('router')->get('/', [
			'as'			=> 'balldeep.admin.menu.index',
			'uses'			=> 'MenuController@index',
			'middleware'	=> 'can:browse,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->get('create', [
			'as'			=> 'balldeep.admin.menu.create',
			'uses'			=> 'MenuController@create',
			'middleware'	=> 'can:create,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->post('create', [
			'as'			=> 'balldeep.admin.menu.store',
			'uses'			=> 'MenuController@store',
			'middleware'	=> 'can:create,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->delete('delete/{menu}', [
			'as'			=> 'balldeep.admin.menu.delete',
			'uses'			=> 'MenuController@delete',
			'middleware'	=> 'can:delete,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->get('manage/{menu}', [
			'as'			=> 'balldeep.admin.menu.manage',
			'uses'			=> 'MenuController@manage',
			'middleware'	=> 'can:edit,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->post('reorder/{menu}', [
			'as'			=> 'balldeep.admin.menu.reorder',
			'uses'			=> 'MenuController@reorder',
			'middleware'	=> 'can:edit,Lainga9\Balldeep\app\Menu'
		]);

		app('router')->group(['prefix' => 'items', 'middleware' => 'can:edit,Lainga9\Balldeep\app\Menu'], function()
		{
			app('router')->post('create/{menu}', [
				'as'	=> 'balldeep.admin.menu.items.store',
				'uses'	=> 'MenuItemsController@store'
			]);

			app('router')->post('add/{menu}', [
				'as'	=> 'balldeep.admin.menu.items.add',
				'uses'	=> 'MenuItemsController@add'
			]);

			app('router')->post('remove/{menu}', [
				'as'	=> 'balldeep.admin.menu.items.remove',
				'uses'	=> 'MenuItemsController@remove'
			]);
		});
	});
});