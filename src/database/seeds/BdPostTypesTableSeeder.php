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
        $types = [
            [
                'name' => 'Post'
            ],
            [
                'name' => 'Page',
                'hierarchical' => 1
            ]
        ];

        foreach( $types as $array )
        {
            $type = PostType::firstOrCreate(['name' => $array['name']]);

            $type->update($array);
        }
    }
}
