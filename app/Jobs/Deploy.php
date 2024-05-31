<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class Deploy implements ShouldQueue
{
    //ShouldBeUnique - until a job finishes processing
    //ShouldBeUniqueUntilProcessing - until a job starts processing
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

//    public function uniqueId()
//    {
//        return 'deployments';
//    }
//
//    public function uniqueFor()
//    {
//        return 60;
//    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        Cache::lock('deployments')->block(10, function () {
            info('Started Deploying');

            sleep(5);

            info('Finished Deploying');
//        });
    }

    public function middleware() {

    }
}
