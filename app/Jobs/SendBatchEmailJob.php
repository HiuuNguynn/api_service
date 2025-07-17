<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBatchEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $batchId;
    public $personIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($batchId, $personIds)
    {
        $this->batchId = $batchId;
        $this->personIds = $personIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $people = User::whereIn('id', $this->personIds)->get();
        
        foreach ($people as $person) {
                $this->sendEmailToPerson($person);
                Log::info("Email sent to person id: {$person->id} ({$person->email}) in batch {$this->batchId}");
        }

        Log::info("Batch {$this->batchId} completed. Sent emails to " . count($people) . " people.");
    }

    /**
     * Send email to a specific person
     *
     * @param Person $person
     * @return void
     */
    private function sendEmailToPerson($person)
    {
        $emailContent = $this->generateEmailContent($person);
        
        Mail::raw($emailContent, function ($message) use ($person) {
            $message->to($person->email)
                   ->subject('Thông báo từ hệ thống - Batch ' . $this->batchId);
        });
    }

    /**
     * Generate email content for a person
     *
     * @param Person $person
     * @return string
     */
    private function generateEmailContent($person)
    {
        return "Hello {$person->name}, this is a test email";
    }
} 