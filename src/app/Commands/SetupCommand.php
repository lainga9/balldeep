<?php

namespace Lainga9\BallDeep\app\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
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
    public function handle()
    {
    	
    }
}
