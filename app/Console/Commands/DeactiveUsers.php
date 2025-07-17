<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\PersonService;
class DeactiveUsers extends Command
{
    protected $PersonService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactive:users';

    /**
     * The console command description.
     *
     * @var string
     */
        protected $description = 'Unactive all users by admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PersonService $personService)
    {
        $this->PersonService = $personService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $this->PersonService->deActivateAllUsers();
       return Command::SUCCESS;
    }
}
