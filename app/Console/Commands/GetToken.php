<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\AuthService;
class getToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:token {email}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get token by email';
    protected $authService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userByEmail = $this->authService->checkEmailExists([
            'email' => $this->argument('email')
        ]);
        $tokenAccess = $this->authService->createAccessToken($userByEmail);
        $this->info($tokenAccess);
    }
}
