<?php

namespace Lainga9\BallDeep\app\Commands;

use Illuminate\Console\Command;
use Roumen\Sitemap\Sitemap;
use Illuminate\Http\File;
use Storage;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balldeep:generate-sitemap {models*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a sitemap to /sitemap.xml';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Sitemap $sitemap)
    {
        $this->info('Checking for sitemap');

        if( Storage::exists('public/sitemap.xml') )
        {
            Storage::delete('public/sitemap.xml');

            $this->info('Sitemap found and deleted');
        }
        else
        {
            $this->info('No sitemap found');
        }
        
        $models = $this->argument('models');

        foreach( $models as $model )
        {
            if( ! class_exists($model) )
            {
                $this->info(sprintf('%s not found', $model));
                
                continue;
            }

            $class = new $model;

            if( ! method_exists($class, 'getSitemapUrl') )
            {
                $this->info(sprintf('getSitemapUrl() method missing on %s', $model));
                
                continue;
            }

            $this->info(sprintf('Adding %s', str_plural($model)));

            $class->chunk(100, function($elems) use (&$sitemap)
            {
                foreach( $elems as $elem )
                {
                    $sitemap->add($elem->getSitemapUrl(), $elem->updated_at->format('c'));
                }
            });
        }

        $this->info('Storing sitemap');

        // generate your sitemap (format, filename)
        $this->info($sitemap->store('xml', 'sitemap'));

        // Move to storage
        Storage::putFileAs('public', new File(public_path('sitemap.xml')), 'sitemap.xml', 'public');
    }
}
