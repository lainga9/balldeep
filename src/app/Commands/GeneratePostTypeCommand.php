<?php

namespace Lainga9\BallDeep\app\Commands;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Console\Command;
use Lainga9\BallDeep\app\PostType;
use Exception;

class GeneratePostTypeCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balldeep:posttype';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup new post types';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PostType $postType)
    {
        parent::__construct();

        $this->postType = $postType;
    }

    /**
     * Allow user to recursively create as many post types
     * as they would like
     * 
     * @return string|boolean
     */
    protected function createPostTypes()
    {
       $name = $this->ask('Name of the post type?');

       $hierarchical = $this->confirm('Should the post type be hierarchical?');

       $type = $this->postType->firstOrCreate(compact('name'));

       $type->update(compact('hierarchical'));

       $this->info(sprintf('Post type %s successfully created', $name));

       $choice = $this->choice('Would you like to add any more post types?', ['No', 'Yes']);

       if( $choice == 'Yes' ) return $this->createPostTypes();

       return false;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createPostTypes();

        return $this->info('Finished bitch!');
    }
}
