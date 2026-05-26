<?php

namespace App\Jobs;

use App\Mail\WeeklyReportMail;
use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class sendWeeklyReportToAdmin implements ShouldQueue
{
    use Queueable,Dispatchable,SerializesModels,InteractsWithQueue;

    public $tries=3;

    public $backoff=[5,10,15];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin=User::where('role','admin')->first();

        $articles=Article::where('status','published')
        ->whereBetween('published_at',[now()->subWeek(),now()])
        ->with('author')->get();

        if($articles->isEmpty()){
            Log::info("No new published articles for this week");
          //  return ;
        }

        Mail::to($admin->email)->send(new WeeklyReportMail(
                     adminName: $admin->name,
                    articles: $articles,
                    startDate: now()->subWeek()->format('Y-m-d'),
                    endDate: now()->format('Y-m-d'),

        ));

        Log::info('Weekly report sent to admin');

    }
    public function failed(Throwable $throwable){

    Log::error('Weekly report failed');
    }
}
