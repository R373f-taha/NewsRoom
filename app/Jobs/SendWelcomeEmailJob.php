<?php

namespace App\Jobs;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable,Dispatchable,SerializesModels,InteractsWithQueue;

    public $tries=3;

    public $backoff=60;


    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user=$user;
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      Mail::to($this->user->email)->send(new WelcomeEmail($this->user));
    }
    public function failed(Throwable $exception){

     Log::error('sending email failed ' . $this->user->email, [
            'user_id' => $this->user->id,
            'error' => $exception->getMessage()
        ]);
    }
}
