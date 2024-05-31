<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Horizon\Contracts\Silenced;

class SendEmail implements ShouldQueue, Silenced
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public $maxExceptions = 2;
    public $deleteWhenMissingModels = true;
    public $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return nulle
     */
    public function handle()
    {
        $user = User::find($this->userId);
        if ($user) {
            info('still reached');
        }
//        throw new \Exception('msg');
//        return $this->release();
    }

    public function tags(){
        return ['mail'];
    }

    public function failed($e)
    {
        info('Failed!');
    }

}
