<?php

namespace App\Console\Commands;

use App\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishPostsAsScheduled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish posts as scheduled.';

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
        $affected = Post::publishPostsAsScheduled();
        $this->comment(Carbon::now()->format('h:i:s') . "\t". $affected . " post(s) has been published via " . $this->signature . " command." . PHP_EOL);
        return;
    }
}
