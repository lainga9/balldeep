<?php

namespace Lainga9\BallDeep\app\Commands;

use Illuminate\Console\Command;
use Lainga9\BallDeep\app\MetaGroup;
use Lainga9\BallDeep\app\PostType;

class AddSeoMetaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balldeep:seo-meta {types*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add standard SEO meta fields to given post types';

    /**
     * Instance of MetaGroup model
     * 
     * @var MetaGroup
     */
    protected $group;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MetaGroup $group, PostType $type)
    {
        parent::__construct();

        $this->group = $group;
        $this->type = $type;
    }

    /**
     * The params required to create the meta group
     * 
     * @return array
     */
    private function getMetaGroupParams()
    {
        return ['name' => 'SEO Meta'];
    }

    /**
     * Return the meta fields which will be added
     * to the group
     * 
     * @return array
     */
    private function getMetaFields()
    {
        return [
            [
                'label' => 'Meta Title',
                'name'  => 'meta_title',
                'type'  => 'text',
                'description' => 'If blank, will default to title'
            ],
            [
                'label' => 'Meta Description',
                'name'  => 'meta_description',
                'type'  => 'textarea',
                'description' => 'If blank, will default to excerpt'
            ],
            [
                'label' => 'Social Title',
                'name'  => 'social_title',
                'type'  => 'text',
                'description' => 'If blank, will default to meta title'
            ],
            [
                'label' => 'Social Description',
                'name'  => 'social_description',
                'type'  => 'textarea',
                'description' => 'If blank, will default to meta description'
            ]
        ];
    }

    /**
     * Create meta group or return existing
     * 
     * @return MetaGroup
     */
    private function createMetaGroup()
    {
        return $this->group->firstOrCreate(
            $this->getMetaGroupParams()
        );
    }

    /**
     * Create the new meta fields and attach them
     * to the group
     * 
     * @param MetaGroup $group
     */
    private function addMetaFieldsToGroup($group)
    {
        $fields = $this->getMetaFields();

        foreach( $fields as $field )
        {
            $group->fields()->create($field);
        }

        return $group;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $group = $this->createMetaGroup();

        $this->info('Group created');

        $group = $this->addMetaFieldsToGroup($group);

        $this->info('Fields attached to group');

        $types = $this->argument('types');

        foreach( $types as $type )
        {
            $model = $this->type->where('slug', $type)->first();

            if( ! $model )
            {
                $this->info(sprintf('Post tye %s not found', $type));

                continue;
            }

            $group->postTypes()->attach($model->id);

            $this->info(sprintf('Group attached to %s', $type));
        }

        return $this->info('Finished bitch!');
    }
}
