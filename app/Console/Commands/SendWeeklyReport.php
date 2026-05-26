<?php

namespace App\Console\Commands;

use App\Jobs\sendWeeklyReportToAdmin;
use Illuminate\Console\Command;

class SendWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly report sent to the admin regarding published articles each week ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $this->info('Weekly report being sent...');

       sendWeeklyReportToAdmin::dispatch();

       $this->info('report successfully added to the queue');
    }
}
