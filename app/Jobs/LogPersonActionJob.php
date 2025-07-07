<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogPersonActionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $action;
    public $personalData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action, $personalData)
    {
        //
        $this->action = $action;
        $this->personalData = $personalData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::channel('daily')->info('Person'.$this->action, [
            'person' => $this->personalData,
        ]);
    }
}
