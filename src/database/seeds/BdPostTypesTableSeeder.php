<?php

use Illuminate\Database\Seeder;
use Lainga9\BallDeep\app\PostType;

class BdPostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Post', 'Page'];

        foreach( $types as $name )
        {
            PostType::firstOrCreate(compact('name'));
        }
    }
}
