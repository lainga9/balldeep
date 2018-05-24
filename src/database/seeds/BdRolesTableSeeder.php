<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Database\Role;
use Illuminate\Console\DetectsApplicationNamespace;
use Lainga9\BallDeep\app\PostType;

class BdRolesTableSeeder extends Seeder
{
    use DetectsApplicationNamespace;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Editor', 'Contributor'];

        foreach( $roles as $title )
        {
            $name = strtolower($title);

            $$name = Role::firstOrCreate([
                'title' => $title,
                'name'  => $name
            ]);
        }

        $model = $this->getAppNamespace() . 'User';

        Bouncer::allow('admin')->everything();

        foreach( PostType::all() as $type )
        {
            Bouncer::allow('editor')->to(['browse', 'create'], $type);

            Bouncer::allow('contributor')->to(['browse', 'create'], $type);
        }

        Bouncer::allow('editor')->to(['view', 'edit', 'delete'], 'Lainga9\BallDeep\app\Post');

        Bouncer::allow('contributor')->toOwn('Lainga9\BallDeep\app\Post');
    }
}
