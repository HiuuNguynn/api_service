<?php

namespace App\Console\Commands;

use App\Service\PersonService;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendBatchEmailToPeopleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-batch-people';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi email cho people theo batch (10 người một lượt) - chỉ gửi cho status = 1';

    /**
     * @var PersonService
     */
    protected $personService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = $this->personService->sendBatchEmailsToPeople();
        Log::info($result);
    }
} 