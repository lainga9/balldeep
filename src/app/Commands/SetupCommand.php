<?php

namespace Lainga9\BallDeep\app\Commands;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Console\Command;
use Schema;
use Lainga9\BallDeep\app\PostType;
use Lainga9\BallDeep\app\Menu;
use Exception;

class SetupCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balldeep:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup helper for new install';

    /**
     * Instance of User model
     * 
     * @var User
     */
    protected $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PostType $postType, Menu $menu)
    {
        parent::__construct();

        $model = '\\' . $this->getAppNamespace() . 'User';

        $this->user = new $model;
        $this->postType = $postType;
        $this->menu = $menu;
    }

    /**
     * Check whether to use existing user or create a new one for admin
     * 
     * @return string
     */
    protected function askForUser()
    {
        return $this->choice('Do you want to create a new admin user or select from existing?', ['New', 'Existing', 'Skip']);
    }

    /**
     * Allow user to search for existing user by email address. If
     * they can't find one allow them to search again (recursively).
     *
     * Also offer user the option to create a new user if they would
     * prefer
     * 
     * @return User|boolean
     */
    protected function findUser()
    {
        $choice = $this->askForUser();

        if( $choice == "Existing" )
        {
            $email = $this->ask('What is their email address?');

            $user = $this->user->where('email', $email)->first();

            if( ! $user )
            {
                $this->info(sprintf('User with email %s not found', $email));

                return $this->findUser();
            }

            return $user;
        }
        elseif( $choice == 'New')
        {
            return $this->createUser();
        }

        // If user has selected to skip creating a user
        else
        {
            return false;
        }
    }

    /**
     * Create a new user based on input
     * 
     * @return User
     */
    protected function createUser()
    {
        $firstName = $this->ask('First Name?');

        $lastName = $this->ask('Last Name?');

        $email = $this->ask('Email?');

        $password = $this->secret('Password?');

        $params = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => sprintf('%s %s', $firstName, $lastName),
            'email' => $email,
            'password' => method_exists($this->user, 'setPasswordAttribute') ? $password : bcrypt($password)
        ];

        if( Schema::hasColumn('users', 'first_name') && Schema::hasColumn('users', 'last_name') )
        {
            $user = $this->user->create(array_except($params, ['name']));
        }
        elseif( Schema::hasColumn('users', 'name') )
        {
            $user = $this->user->create(array_except($params, ['first_name', 'last_name']));   
        }

        return $user;
    }

    /**
     * Allow user to recursively create as many post types
     * as they would like
     * 
     * @return string|boolean
     */
    protected function createPostTypes()
    {
        $choice = $this->choice('Would you like to add any additional post types?', ['No', 'Yes']);

        if( $choice == 'Yes' )
        {
           $name = $this->ask('Name of the post type?');

           $hierarchical = $this->confirm('Should the post type be hierarchical?');

           $type = $this->postType->firstOrCreate(compact('name'));

           $type->update(compact('hierarchical'));

           $this->info(sprintf('Post type %s successfully created', $name));

           return $this->createPostTypes();
        }
        else
        {
            return false;
        }
    }

    /**
     * Allow user to recursively create as many menus as they would like
     * 
     * @return string|boolean
     */
    protected function createMenus()
    {
        $choice = $this->choice('Would you like to add any menus?', ['No', 'Yes']);

        if( $choice == 'Yes' )
        {
           $name = $this->ask('Name of the menu?');

           $this->menu->firstOrCreate(compact('name'));

           $this->info(sprintf('Menu %s successfully created', $name));

           return $this->createMenus();
        }
        else
        {
            return false;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->findUser();

        if( $user )
        {
            $user->assign('admin');

            $this->info(sprintf('Admin role successfully assigned to %s', $user->email));
        }

        $this->createPostTypes();

        $this->createMenus();

        return $this->info('Finished bitch!');
    }
}
