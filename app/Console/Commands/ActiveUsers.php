<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\PersonService;  
class ActiveUsers extends Command
{
    /**
     * @var PersonService
     */
    protected $personService;

    protected $signature = 'active:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Active all users by admin';

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
        $this->personService->activateAllUsers();
        return Command::SUCCESS;
    }
}
